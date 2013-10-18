<?php

namespace Kazan\Articler\Repository;

use Exception;

class RepositoryException extends Exception
{

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}
