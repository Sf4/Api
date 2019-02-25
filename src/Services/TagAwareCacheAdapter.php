<?php

namespace Sf4\Api\Services;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Contracts\Cache\CallbackInterface;
use Symfony\Contracts\Cache\ItemInterface;

class TagAwareCacheAdapter implements CacheAdapterInterface
{
    protected $cache;

    public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        $redisConnection = RedisAdapter::createConnection(
            'redis://localhost'
        );
        $redisAdapter = new RedisAdapter(
            $redisConnection,
            '',
            0
        );
        $this->cache = new TagAwareAdapter(
            $redisAdapter,
            $redisAdapter
        );
    }

    /**
     * Returns a Cache Item representing the specified key.
     *
     * This method must always return a ItemInterface object, even in case of
     * a cache miss. It MUST NOT return null.
     *
     * @param string $key
     *   The key for which to return the corresponding Cache Item.
     *
     * @throws InvalidArgumentException
     *   If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     *
     * @return ItemInterface
     *   The corresponding Cache Item.
     */
    public function getItem($key)
    {
        return $this->getCache()->getItem($key);
    }

    /**
     * @return TagAwareAdapter
     */
    public function getCache(): TagAwareAdapter
    {
        return $this->cache;
    }

    /**
     * Returns a traversable set of cache items.
     *
     * @param string[] $keys
     *   An indexed array of keys of items to retrieve.
     *
     * @throws InvalidArgumentException
     *   If any of the keys in $keys are not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     *
     * @return array|\Traversable
     *   A traversable collection of Cache Items keyed by the cache keys of
     *   each item. A Cache item will be returned for each key, even if that
     *   key is not found. However, if no keys are specified then an empty
     *   traversable MUST be returned instead.
     */
    public function getItems(array $keys = array())
    {
        return $this->getCache()->getItems($keys);
    }

    /**
     * Confirms if the cache contains specified cache item.
     *
     * Note: This method MAY avoid retrieving the cached value for performance reasons.
     * This could result in a race condition with ItemInterface::get(). To avoid
     * such situation use ItemInterface::isHit() instead.
     *
     * @param string $key
     *   The key for which to check existence.
     *
     * @throws InvalidArgumentException
     *   If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     *
     * @return bool
     *   True if item exists in the cache, false otherwise.
     */
    public function hasItem($key)
    {
        return $this->getCache()->hasItem($key);
    }

    /**
     * Deletes all items in the pool.
     *
     * @return bool
     *   True if the pool was successfully cleared. False if there was an error.
     */
    public function clear()
    {
        return $this->getCache()->clear();
    }

    /**
     * Removes the item from the pool.
     *
     * @param string $key
     *   The key to delete.
     *
     * @throws InvalidArgumentException
     *   If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     *
     * @return bool
     *   True if the item was successfully removed. False if there was an error.
     */
    public function deleteItem($key)
    {
        return $this->getCache()->deleteItem($key);
    }

    /**
     * Removes multiple items from the pool.
     *
     * @param string[] $keys
     *   An array of keys that should be removed from the pool.
     * @throws InvalidArgumentException
     *   If any of the keys in $keys are not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     *
     * @return bool
     *   True if the items were successfully removed. False if there was an error.
     */
    public function deleteItems(array $keys)
    {
        return $this->getCache()->deleteItems($keys);
    }

    /**
     * Persists a cache item immediately.
     *
     * @param CacheItemInterface $item
     *   The cache item to save.
     *
     * @return bool
     *   True if the item was successfully persisted. False if there was an error.
     */
    public function save(CacheItemInterface $item)
    {
        return $this->getCache()->save($item);
    }

    /**
     * Sets a cache item to be persisted later.
     *
     * @param CacheItemInterface $item
     *   The cache item to save.
     *
     * @return bool
     *   False if the item could not be queued or if a commit was attempted and failed. True otherwise.
     */
    public function saveDeferred(CacheItemInterface $item)
    {
        return $this->getCache()->saveDeferred($item);
    }

    /**
     * Persists any deferred cache items.
     *
     * @return bool
     *   True if all not-yet-saved items were successfully saved or there were none. False otherwise.
     */
    public function commit()
    {
        return $this->getCache()->commit();
    }

    /**
     * Fetches a value from the pool or computes it if not found.
     *
     * On cache misses, a callback is called that should return the missing value.
     * This callback is given a PSR-6 ItemInterface instance corresponding to the
     * requested key, that could be used e.g. for expiration control. It could also
     * be an ItemInterface instance when its additional features are needed.
     *
     * @param string $key The key of the item to retrieve from the cache
     * @param callable|CallbackInterface $callback Should return the computed value for the given key/item
     * @param float|null $beta A float that, as it grows, controls the likeliness of triggering
     *        early expiration. 0 disables it, INF forces immediate expiration.
     *        The default (or providing null) is implementation dependent but should
     *        typically be 1.0, which should provide optimal stampede protection.
     *        See https://en.wikipedia.org/wiki/Cache_stampede#Probabilistic_early_expiration
     * @param array &$metadata The metadata of the cached item {@see ItemInterface::getMetadata()}
     *
     * @return mixed The value corresponding to the provided key
     *
     */
    public function get(string $key, callable $callback, float $beta = null, array &$metadata = null)
    {
        return $this->getCache()->get($key, $callback, $beta, $metadata);
    }

    /**
     * Removes an item from the pool.
     *
     * @param string $key The key to delete
     *
     * @return bool True if the item was successfully removed, false if there was any error
     */
    public function delete(string $key): bool
    {
        return $this->getCache()->delete($key);
    }

    /**
     * Invalidates cached items using tags.
     *
     * @param string[] $tags An array of tags to invalidate
     *
     * @return bool True on success
     *
     * @throws InvalidArgumentException When $tags is not valid
     */
    public function invalidateTags(array $tags)
    {
        return $this->getCache()->invalidateTags($tags);
    }
}
