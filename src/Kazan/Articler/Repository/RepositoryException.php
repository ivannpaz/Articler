<?php

namespace Kazan\Articler\Repository;

use Exception;

class RepositoryException extends Exception
{

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}
