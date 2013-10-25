<?php

namespace Kazan\Articler;

use Kazan\Articler\Repository\RepositoryInterface;
use Kazan\Articler\Parser\ParserInterface;
use Kazan\Articler\Cache\CacheInterface;
use Kazan\Articler\Config\ConfigInterface;

/**
 * Articler articles provider
 */
class Articler
{

    /**
     * Cache lifetime
     *
     * This should be read from the Config dependency, but for now
     * we will use it as a fallback.
     */
    const CACHE_TTL = 1440;

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @var ParserInterface
     */
    protected $parser;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * Construct the ArticleBin
     *
     * @param RepositoryInterface $repository
     * @param ParserInterface     $parser
     * @param CacheInterface      $cache
     */
    public function __construct(
        RepositoryInterface $repository,
        ParserInterface $parser,
        CacheInterface $cache,
        ConfigInterface $config
    ) {
        $this->repository = $repository;
        $this->parser = $parser;
        $this->cache = $cache;
        $this->config = $config;
    }

    /**
     * Retrieve the list of articles stored in this bin.
     *
     * @param   string  $collection
     * @param   integer $start
     * @param   integer $limit
     *
     * @return  Kazan\Articler\Article\Toc
     */
    public function getList($collection, $start=0, $limit=0)
    {
        $key = "articles-bin-list-{$collection}";
        $ttl = $this->config->get('cache_ttl', self::CACHE_TTL);

        if (!$this->cache->has($key)) {
            $list = $this->repository->getList($collection, $start, $limit);

            if ($list !== null) {
                $this->cache->put($key, $list, $ttl);
            }

            return $list;
        }

        return $this->cache->get($key);
    }

    /**
     * Retrieve a single article content from the specified bin.
     *
     * @param   string  $collection
     * @param   string  $id
     * @return  Kazan\Articler\Article\Article
     */
    public function getArticle($collection, $id)
    {
        $key = "articles-bin-item-{$collection}-{$id}";
        $ttl = $this->config->get('cache_ttl', self::CACHE_TTL);

        if (!$this->cache->has($key)) {
            $article = $this->repository->getArticle($collection, $id);

            if ($article !== null) {
                $parsed = $this->parser->parse($article->getContent());
                $article->setContent($parsed);
                $this->cache->put($key, $article, $ttl);
            }

            return $article;
        }

        return $this->cache->get($key);
    }

}
