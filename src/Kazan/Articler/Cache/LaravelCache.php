<?php

namespace Kazan\Articler\Cache;

class LaravelCache implements CacheInterface
{

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return \Cache::has($key);
    }

    /**
     * {@inheritdoc}
     */
    public function put($key, $object, $ttl)
    {
        \Cache::put($key, $object, $ttl);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        return \Cache::get($key, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function forget($key)
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        //
    }
}
