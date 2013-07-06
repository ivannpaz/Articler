<?php

namespace Kazan\Articler\Cache;

/**
 * 
 */
class LaravelCache implements CacheInterface
{

    public function has($key)
    {
        return \Cache::has($key);
    }

    public function put($key, $object, $ttl)
    {
        \Cache::put($key, $object, $ttl);
    }

    public function get($key, $default = null)
    {
        return \Cache::get($key, $default);
    }

    public function forget($key)
    {
        //
    }

    public function clear()
    {
        //
    }

}
