<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 5.03.19
 * Time: 9:28
 */

namespace Sf4\Api\RequestHandler\Traits;

use Sf4\Api\Services\CacheAdapterInterface;

interface CacheAdapterTraitInterface
{
    /**
     * @return CacheAdapterInterface
     */
    public function getCacheAdapter(): CacheAdapterInterface;

    /**
     * @param CacheAdapterInterface $cacheAdapter
     */
    public function setCacheAdapter(CacheAdapterInterface $cacheAdapter): void;

    /**
     * @param string $cacheKey
     * @param \Closure $closure
     * @param array $tags
     * @param null $expiresAfter
     * @return mixed|null
     * @throws \Psr\Cache\CacheException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getCacheDataOrAdd(string $cacheKey, \Closure $closure, array $tags = [], $expiresAfter = null);

    /**
     * @param string $cacheKey
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function removeByKey(string $cacheKey);

    /**
     * @param array $tags
     */
    public function removeByTag(array $tags);
}
