<?php

namespace Kazan\Articler\Parser;

class NullParser implements ParserInterface
{

    public function parse($content)
    {
        return $content;
    }
}
