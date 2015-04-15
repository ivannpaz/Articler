<?php

namespace Kazan\Articler\Filesystem;

/**
 * Filesystem loader interface.
 *
 * @package Kazan\Articler
 */
interface FilesystemInterface
{

    public function get($file);
}
