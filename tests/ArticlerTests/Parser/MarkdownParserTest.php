<?php

namespace Kazan\ArticlerTests\Parser;

use Kazan\ArticlerTests\AbstractTestCase;
use Kazan\Articler\Parser\MarkdownParser;

use Mockery as m;

class MarkdownParserTest extends AbstractTestCase
{

    public function tearDown()
    {
        m::close();
    }

    public function testParse()
    {
        $original   = '**bold-me**';
        $parsed     = "<p><strong>bold-me</strong></p>\n";

        $object = new MarkdownParser();

        $this->assertEquals(
            $parsed,
            $object->parse($original)
        );
    }
}
