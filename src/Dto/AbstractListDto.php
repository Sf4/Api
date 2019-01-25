<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 25.01.19
 * Time: 10:01
 */

namespace Sf4\Api\Dto;

abstract class AbstractListDto extends AbstractDto
{
    /** @var array $items */
    protected $items;

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }
}
