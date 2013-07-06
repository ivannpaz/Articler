<?php

namespace Kazan\Articler\Config;

/**
 * 
 */
class LaravelConfig implements ConfigInterface
{

    public function get($key, $default = false)
    {
        return \Config::get($key, $default);
    }
}
