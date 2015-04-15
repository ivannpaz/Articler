<?php

namespace Kazan\Articler\Cache;

class NullCache implements CacheInterface
{

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function put($key, $object, $ttl = 0)
    {
        //unimplemented
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function forget($key)
    {
        //unimplemented
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        //unimplemented
    }
}
