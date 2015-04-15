<?php

namespace Kazan\Articler\Config;

class LaravelConfig implements ConfigInterface
{

    protected $prefix = 'articler::';

    public function get($key, $default = false)
    {
        return \Config::get("{$this->prefix}{$key}", $default);
    }
}
