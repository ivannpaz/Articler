<?php

namespace Kazan\Articler\Cache;

/**
 * 
 */
interface CacheInterface
{

    public function has($key);

    public function put($key, $object, $ttl);

    public function get($key, $default = null);

    public function forget($key);

    public function clear();

}
