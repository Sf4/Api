<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 21.02.19
 * Time: 20:22
 */

namespace Sf4\Api\RequestHandler\Traits;

use Sf4\Api\Services\CacheAdapterInterface;

trait CacheAdapterTrait
{

    /** @var CacheAdapterInterface $cacheAdapter */
    protected $cacheAdapter;

    /**
     * @return CacheAdapterInterface
     */
    public function getCacheAdapter(): CacheAdapterInterface
    {
        return $this->cacheAdapter;
    }

    /**
     * @param CacheAdapterInterface $cacheAdapter
     */
    public function setCacheAdapter(CacheAdapterInterface $cacheAdapter): void
    {
        $this->cacheAdapter = $cacheAdapter;
    }
}
