<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 31.01.19
 * Time: 9:41
 */

namespace Sf4\Api\Dto\Traits;

use Sf4\Api\Dto\Filter\FilterInterface;

trait FilterTrait
{

    /** @var FilterInterface $filter */
    protected $filter = null;

    /**
     * @return FilterInterface
     */
    public function getFilter(): ?FilterInterface
    {
        return $this->filter;
    }

    /**
     * @param FilterInterface $filter
     */
    public function setFilter(FilterInterface $filter): void
    {
        $this->filter = $filter;
    }
}
