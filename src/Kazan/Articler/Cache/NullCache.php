<?php

namespace Kazan\Articler\Cache;

/**
 * 
 */
class NullCache implements CacheInterface
{

    public function has($key)
    {
        return false;
    }

    public function put($key, $object, $ttl = 0)
    {
        //unimplemented
    }

    public function get($key, $default = null)
    {
        return $default;
    }

    public function forget($key)
    {
        //unimplemented
    }

    public function clear()
    {
        //unimplemented
    }

}
