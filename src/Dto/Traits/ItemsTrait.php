<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 31.01.19
 * Time: 9:45
 */

namespace Sf4\Api\Dto\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Sf4\Api\Dto\DtoInterface;

trait ItemsTrait
{
    /** @var ArrayCollection $items */
    protected $items;

    /** @var int $total */
    protected $total = 0;

    /** @var int $count */
    protected $count = 0;

    /**
     * @param DtoInterface $dto
     */
    public function addItem(DtoInterface $dto): void
    {
        $this->items->add($dto);
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
}
