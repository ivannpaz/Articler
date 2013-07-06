<?php

namespace Kazan\ArticlerTests\Repository;

use Kazan\Articler\Filesystem\FileNotFoundException;
use Kazan\ArticlerTests\AbstractTestCase;


class FileNotFoundExceptionTest extends AbstractTestCase
{

    function testExceptionToString()
    {
        $message = 'exception-message';

        try {
            throw new FileNotFoundException($message);
        } catch (FileNotFoundException $e) {
            $this->assertContains($message, (string)$e);
            $this->assertContains('FileNotFoundException', (string)$e);
        }
    }
}
