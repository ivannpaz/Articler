<?php

namespace Kazan\Articler\Article;

use JsonSerializable;

/**
 * Representation of a collection Toc
 */
class Toc implements JsonSerializable
{

    /**
     * @var Article[]
     */
    protected $articles;


    public function __construct($articles = array())
    {
        $this->articles = $articles;
    }

    /**
     * Gets the value of articles.
     *
     * @return Article[]
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Sets the value of articles.
     *
     * @param Article[] $articles the articles
     *
     * @return self
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;

        return $this;
    }

    /**
     * Add an article to this ToC.
     *
     * @param Article $article
     */
    public function addArticle(Article $article)
    {
        $this->articles[] = $article;

        return $this;
    }

    public function jsonSerialize()
    {
        return $this->articles;
    }
}
