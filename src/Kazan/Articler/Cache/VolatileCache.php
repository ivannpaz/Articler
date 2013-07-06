<?php

namespace Kazan\Articler\Cache;

/**
 * 
 */
class VolatileCache implements CacheInterface
{

    protected $items = array();

    public function has($key)
    {
        return !empty($this->items[$key]);
    }

    public function put($key, $object, $ttl = 0)
    {
        $this->items[$key] = $object;
    }

    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->items[$key] : $default;
    }

    public function forget($key)
    {
        if ($this->has($key)) {
            unset($this->items[$key]);
        }
    }

    public function clear()
    {
        $this->items = array();
    }

}
