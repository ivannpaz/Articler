<?php

namespace Kazan\ArticlerTests\Repository;

use Kazan\Articler\Repository\RepositoryException;
use Kazan\ArticlerTests\AbstractTestCase;

class RepositoryExceptionTest extends AbstractTestCase
{

    function testExceptionToString()
    {
        $message = 'exception-message';

        try {
            throw new RepositoryException($message);
        } catch (RepositoryException $e) {

            $this->assertContains($message, (string)$e);
            $this->assertContains('RepositoryException', (string)$e);
        }
    }
}
