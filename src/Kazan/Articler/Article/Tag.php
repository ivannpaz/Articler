<?php

namespace Kazan\Articler\Article;

use JsonSerializable;

/**
 * Representation of a single Tag
 */
class Tag implements JsonSerializable
{

    /**
     * @var string
     */
    protected $title;

    /**
     * Build the Tag
     */
    public function __construct($title)
    {
        $this->title = $title;
    }

    /**
     * Gets the value of title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the value of title.
     *
     * @param string $title the title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function jsonSerialize()
    {
        return $this->title;
    }
}
