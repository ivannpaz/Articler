<?php

namespace Kazan\Articler\Cache;

class VolatileCache implements CacheInterface
{

    /** @var array */
    protected $items = array();

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return !empty($this->items[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function put($key, $object, $ttl = 0)
    {
        $this->items[$key] = $object;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->items[$key] : $default;
    }

    /**
     * {@inheritdoc}
     */
    public function forget($key)
    {
        if ($this->has($key)) {
            unset($this->items[$key]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->items = array();
    }
}
