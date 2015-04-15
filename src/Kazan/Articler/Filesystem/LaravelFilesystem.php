<?php

namespace Kazan\Articler\Filesystem;

class LaravelFilesystem implements FilesystemInterface
{

    public function get($file)
    {
        return \File::get($file);
    }
}
