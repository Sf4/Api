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
    const FIELD_FILTER = 'filter';
    const FIELD_ORDER = 'order';

    /**
     * @return FilterInterface|null
     */
    public function getFilter(): ?FilterInterface;

    /**
     * @param FilterInterface $filter
     */
    public function setFilter(FilterInterface $filter): void;
}
