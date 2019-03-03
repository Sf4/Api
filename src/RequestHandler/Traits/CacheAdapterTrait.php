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

    /**
     * @param string $cacheKey
     * @param \Closure $closure
     * @param array $tags
     * @param null $expiresAfter
     * @return mixed|null
     * @throws \Psr\Cache\CacheException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getCacheDataOrAdd(string $cacheKey, \Closure $closure, array $tags = [], $expiresAfter = null)
    {
        $data = null;
        $cacheItem = $this->getCacheAdapter()->getItem($cacheKey);
        if ($cacheItem->isHit()) {
            $data = $cacheItem->get();
        } else {
            $data = $closure();
            if ($data) {
                $cacheItem->set($data);
                if (!empty($tags)) {
                    $cacheItem->tag($tags);
                }
                if ($expiresAfter) {
                    $cacheItem->expiresAfter($expiresAfter);
                }
                $this->getCacheAdapter()->save($cacheItem);
            }
        }

        return $data;
    }
}
