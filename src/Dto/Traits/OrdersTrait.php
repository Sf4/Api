<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 31.01.19
 * Time: 9:44
 */

namespace Sf4\Api\Dto\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Sf4\Api\Dto\Order\OrderInterface;

trait OrdersTrait
{

    abstract protected function arrayCollectionToArray(ArrayCollection $items);

    /** @var ArrayCollection $orders */
    private $orders;

    /**
     * @return ArrayCollection
     */
    public function getOrders(): ArrayCollection
    {
        return $this->orders;
    }

    /**
     * @param ArrayCollection $orders
     */
    public function setOrders(ArrayCollection $orders): void
    {
        $this->orders = $orders;
    }

    /**
     * @param OrderInterface|null $order
     */
    public function addOrder(OrderInterface $order): void
    {
        $this->orders->add($order);
    }

    protected function ordersToArray(): array
    {
        return $this->arrayCollectionToArray($this->getOrders());
    }
}
