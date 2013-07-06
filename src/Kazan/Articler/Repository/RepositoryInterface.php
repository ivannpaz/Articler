<?php

namespace Kazan\Articler\Repository;

/**
 * Documents loader interface.
 *
 * @package Kazan\Articler
 */
interface RepositoryInterface
{

    /**
     * Get the list of articles in this collection.
     *
     * @param  string   $collection
     *
     * @throws RepositoryException
     *
     * @return Kazan\Articler\Article\Toc
     */
    public function getList($collection);

    /**
     * Get a given article identified by $id from the $collection.
     *
     * @param  string   $collection
     * @param  mixed    $id
     *
     * @throws RepositoryException
     *
     * @return Kazan\Articler\Article\Article
     */
    public function getArticle($collection, $id);

}
