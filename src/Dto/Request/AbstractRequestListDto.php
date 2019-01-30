<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 29.01.19
 * Time: 9:45
 */

namespace Sf4\Api\Dto\Request;

use Sf4\Api\Dto\Filter\FilterInterface;
use Sf4\Populator\Populator;

abstract class AbstractRequestListDto extends AbstractRequestDto implements RequestListDtoInterface
{
    /** @var FilterInterface $filter */
    protected $filter;

    /**
     * @param array $data
     * @throws \ReflectionException
     */
    public function populate(array $data): void
    {
        if(false === isset($data[static::FIELD_FILTER])) {
            return ;
        }
        $filterData = $data[static::FIELD_FILTER];

        if(true === is_object($filterData)) {
            $populator = new Populator();
            $filterData = $populator->unpopulate($filterData);
        }
        if(isset($filterData) && is_array($filterData)) {
            $this->getFilter()->populate($filterData);
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $filterData = [];
        if($this->getFilter()) {
            $filterData = $this->getFilter()->toArray();
        }
        return [
            static::FIELD_FILTER => $filterData
        ];
    }

    protected abstract function getFilterClass(): string;

    /**
     * @return FilterInterface|null
     */
    public function getFilter(): ?FilterInterface
    {
        if(!$this->filter) {
            $class = $this->getFilterClass();
            $this->filter = new $class();
        }
        return $this->filter;
    }

    /**
     * @param FilterInterface $filter
     */
    public function setFilter(FilterInterface $filter): void
    {
        $this->filter = $filter;
    }
}
