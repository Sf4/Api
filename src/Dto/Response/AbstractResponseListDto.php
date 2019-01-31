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
use Sf4\Api\Dto\Order\OrderInterface;
use Sf4\Api\Dto\Request\RequestListDtoInterface;
use Sf4\Api\Dto\Traits\FilterTrait;
use Sf4\Api\Dto\Traits\ItemsTrait;
use Sf4\Api\Dto\Traits\OrdersTrait;
use Sf4\Api\Dto\Traits\PaginationTrait;

abstract class AbstractResponseListDto extends AbstractResponseDto
{
    use ItemsTrait;
    use PaginationTrait;
    use FilterTrait;
    use OrdersTrait;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->orders = new ArrayCollection();
        parent::__construct();
    }

    public abstract function getListItemClass(): string;

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();
        $data['items'] = $this->getItemsData();
        $data[RequestListDtoInterface::FIELD_FILTER] = $this->getFilterData();
        $data[RequestListDtoInterface::FIELD_SORT] = $this->getSortData();
        return $data;
    }

    protected function getItemsData(): array
    {
        $data = [];
        /** @var DtoInterface $item */
        foreach($this->items as $item) {
            $data[] = $item->toArray();
        }

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

    protected function getSortData(): array
    {
        $data = [];
        /** @var OrderInterface $order */
        foreach($this->getOrders() as $order) {
            $data[] = $order->toArray();
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
}
