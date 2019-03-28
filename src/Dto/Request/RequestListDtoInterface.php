<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 29.01.19
 * Time: 9:46
 */

namespace Sf4\Api\Dto\Request;

use Sf4\Api\Dto\Filter\FilterInterface;

interface RequestListDtoInterface
{
    public const FIELD_FILTER = 'filter';
    public const FIELD_SORT = 'sort';

    /**
     * @return FilterInterface|null
     */
    public function getFilter(): ?FilterInterface;

    /**
     * @param FilterInterface $filter
     */
    public function setFilter(FilterInterface $filter): void;
}
