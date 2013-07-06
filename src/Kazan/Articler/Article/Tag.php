<?php

namespace Kazan\Articler\Article;

/**
 * Representation of a single Tag
 */
class Tag
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
}
