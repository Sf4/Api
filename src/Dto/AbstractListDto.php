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
    /** @var array $list */
    protected $list;

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->list;
    }

    /**
     * @param array $list
     */
    public function setList(array $list): void
    {
        $this->list = $list;
    }
}
