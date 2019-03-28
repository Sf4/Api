<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 25.01.19
 * Time: 17:20
 */

namespace Sf4\Api\Dto\Traits;

trait PaginationTrait
{

    /** @var int $itemsPerPage */
    protected $itemsPerPage = 15;

    /** @var int $totalPages */
    protected $totalPages = 0;

    /** @var int $currentPage */
    protected $currentPage = 1;

    /** @var int|null $nextPage */
    protected $nextPage;

    /** @var int|null $previousPage */
    protected $previousPage;

    /**
     * @return int
     */
    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    /**
     * @param int $itemsPerPage
     */
    public function setItemsPerPage(int $itemsPerPage): void
    {
        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    /**
     * @param int $totalPages
     */
    public function setTotalPages(int $totalPages): void
    {
        $this->totalPages = $totalPages;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @param int $currentPage
     */
    public function setCurrentPage(int $currentPage): void
    {
        $this->currentPage = $currentPage;
    }

    /**
     * @return int|null
     */
    public function getNextPage(): ?int
    {
        return $this->nextPage;
    }

    /**
     * @param int|null $nextPage
     */
    public function setNextPage(?int $nextPage): void
    {
        $this->nextPage = $nextPage;
    }

    /**
     * @return int|null
     */
    public function getPreviousPage(): ?int
    {
        return $this->previousPage;
    }

    /**
     * @param int|null $previousPage
     */
    public function setPreviousPage(?int $previousPage): void
    {
        $this->previousPage = $previousPage;
    }
}
