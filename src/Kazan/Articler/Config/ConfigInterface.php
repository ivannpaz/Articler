<?php

namespace Kazan\Articler\Config;

interface ConfigInterface
{

    public function get($key, $default = null);
}
