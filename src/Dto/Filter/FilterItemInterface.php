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
    public const TYPE_LIKE = 'like';
    public const TYPE_EQUAL = 'equal';
    public const TYPE_NOT_EQUAL = 'not_equal';
    public const TYPE_IN = 'in';
    public const TYPE_NOT_IN = 'not_in';
    public const TYPE_IS_NULL = 'is_null';
    public const TYPE_NOT_NULL = 'not_null';

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
