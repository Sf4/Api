<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 28.01.19
 * Time: 18:53
 */

namespace Sf4\Api\Dto\Filter;

class BaseFilterItem implements FilterItemInterface
{
    protected $type;

    protected $value;

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }
}
