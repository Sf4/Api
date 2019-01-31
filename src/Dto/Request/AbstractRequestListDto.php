<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 29.01.19
 * Time: 9:45
 */

namespace Sf4\Api\Dto\Request;

use Doctrine\Common\Collections\ArrayCollection;
use Sf4\Api\Dto\Filter\FilterInterface;
use Sf4\Api\Dto\Order\OrderInterface;
use Sf4\Api\Dto\Traits\FilterTrait;
use Sf4\Api\Dto\Traits\OrdersTrait;
use Sf4\Populator\Populator;

abstract class AbstractRequestListDto extends AbstractRequestDto implements RequestListDtoInterface
{

    use FilterTrait;
    use OrdersTrait;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @param array $data
     * @throws \ReflectionException
     */
    public function populate(array $data): void
    {
        $this->populateFilter($data);
        $this->populateOrder($data);
    }

    /**
     * @param array $data
     * @throws \ReflectionException
     */
    protected function populateFilter(array $data)
    {
        $filterData = $this->getFieldData($data, static::FIELD_FILTER);
        if($filterData) {
            $this->getFilter()->populate($filterData);
        }
    }

    protected function populateOrder(array $data)
    {
        $sortData = $this->getFieldData($data, static::FIELD_SORT);
        if($sortData) {
            $orderClass = $this->getOrderClass();
            foreach($sortData as $orderData) {
                $orderData = $this->unpopulateObject($orderData);
                /** @var OrderInterface $order */
                $order = new $orderClass();
                $order->populate($orderData);
                $this->addOrder($order);
            }
        }
    }

    /**
     * @param array $data
     * @param string $field
     * @return array|null
     */
    protected function getFieldData(array $data, string $field): ?array
    {
        if(false === isset($data[$field])) {
            return null;
        }

        $data  = $this->unpopulateObject($data[$field]);

        if(is_array($data)) {
            return $data;
        }

        return null;
    }

    /**
     * @param $object
     * @return array|null
     */
    protected function unpopulateObject($object): ?array
    {
        $response = null;
        if(true === is_object($object)) {
            $populator = new Populator();
            $response = $populator->unpopulate($object);
        } else if(is_array($object)) {
            $response = $object;
        } else if(is_scalar($object)) {
            $response = [$object];
        }
        return $response;
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
        $sortData = [];
        /** @var OrderInterface $order */
        foreach($this->getOrders() as $order) {
            $sortData[] = $order->toArray();
        }
        return [
            static::FIELD_FILTER => $filterData,
            static::FIELD_SORT => $sortData
        ];
    }

    protected abstract function getFilterClass(): string;

    protected abstract function getOrderClass(): string;

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
}
