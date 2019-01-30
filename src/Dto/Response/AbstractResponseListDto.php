<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 29.01.19
 * Time: 9:36
 */

namespace Sf4\Api\Dto\Response;

use Doctrine\Common\Collections\ArrayCollection;
use Sf4\Api\Dto\DtoInterface;
use Sf4\Api\Dto\Filter\FilterInterface;
use Sf4\Api\Dto\Traits\PaginationTrait;

abstract class AbstractResponseListDto extends AbstractResponseDto
{
    use PaginationTrait;

    /** @var ArrayCollection $items */
    protected $items;

    /** @var int $total */
    protected $total = 0;

    /** @var int $count */
    protected $count = 0;

    /** @var FilterInterface $filter */
    protected $filter = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        parent::__construct();
    }

    public abstract function getListItemClass(): string;

    /**
     * @param DtoInterface $dto
     */
    public function addItem(DtoInterface $dto)
    {
        $this->items->add($dto);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();
        $data['items'] = [];
        foreach($this->items as $item) {
            if($item instanceof DtoInterface) {
                $data['items'][] = $item->toArray();
            }
        }
        $data['filter'] = $this->getFilterData();
        return $data;
    }

    protected function getFilterData(): array
    {
        $data = [];
        if($this->getFilter() instanceof FilterInterface) {
            $data = $this->getFilter()->toArray();
        }

        return $data;
    }

    /**
     * @param array $data
     * @throws \ReflectionException
     */
    public function populate(array $data): void
    {
        $listItemClass = $this->getListItemClass();
        foreach($data as $item) {
            if(is_array($item)) {
                $dto = new $listItemClass();
                if($dto instanceof DtoInterface) {
                    $dto->populate($item);
                    $this->addItem($dto);
                }
            }
        }

        $this->setCount($this->items->count());
        if($this->getTotal() <= 0) {
            $this->setTotal($this->getCount());
        }

        $this->setTotalPages(ceil($this->getTotal() / $this->getItemsPerPage()));

        if($this->getTotalPages() > $this->getCurrentPage()) {
            $this->setNextPage($this->getCurrentPage() + 1);
        }
        if($this->getCurrentPage() > 1) {
            $this->setPreviousPage($this->getCurrentPage() - 1);
        }
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return FilterInterface
     */
    public function getFilter(): ?FilterInterface
    {
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
