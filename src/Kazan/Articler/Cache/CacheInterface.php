<?php

namespace Kazan\Articler\Cache;

interface CacheInterface
{

    /**
     * Check if $key exists in cache backend.
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function has($key);

    /**
     * Store $object in cache.
     *
     * @param  string $key
     * @param  mixed  $object
     * @param  int    $ttl
     */
    public function put($key, $object, $ttl);

    /**
     * Retrieve object identified by $key.
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Remove object from cache backend.
     *
     * @param  string $key
     */
    public function forget($key);

    /**
     * Clear the whole cache backend.
     */
    public function clear();
}
