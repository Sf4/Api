<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 28.01.19
 * Time: 18:54
 */

namespace Sf4\Api\Dto\Filter;

interface FilterItemInterface
{
    const TYPE_LIKE = 'like';
    const TYPE_EQUAL = 'equal';
    const TYPE_IN = 'in';
    const TYPE_NOT_IN = 'not_in';
    const TYPE_IS_NULL = 'is_null';
    const TYPE_NOT_NULL = 'not_null';

    /**
     * @return mixed
     */
    public function getType();

    /**
     * @param mixed $type
     */
    public function setType($type): void;

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param mixed $value
     */
    public function setValue($value): void;
}
