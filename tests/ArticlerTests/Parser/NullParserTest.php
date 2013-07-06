<?php

namespace Kazan\ArticlerTests\Parser;

use Kazan\ArticlerTests\AbstractTestCase;
use Kazan\Articler\Parser\NullParser;

class NullParserTest extends AbstractTestCase
{

    public function testParse()
    {
        $original   = '**bold-me**';

        $object = new NullParser();

        $this->assertEquals(
            $original,
            $object->parse($original)
        );
    }

}
