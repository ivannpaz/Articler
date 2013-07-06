<?php

namespace Kazan\Articler\Parser;

use Michelf\MarkdownExtra;

/**
 * 
 */
class MarkdownParser implements ParserInterface
{

    public function parse($content)
    {
        $markdownParser = new MarkdownExtra();

        return $markdownParser->defaultTransform($content);
    }

}
