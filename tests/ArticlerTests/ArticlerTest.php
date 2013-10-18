<?php

namespace Kazan\ArticlerTests;

use Mockery as m;

use Kazan\Articler\Article\Article;
use Kazan\Articler\Articler;

class ArticlerTest extends AbstractTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @dataProvider articlesListProvider
     */
    public function testGetList($isCached)
    {
        $collection = 'articles-collection';

        $repository = m::mock('Kazan\Articler\Repository\RepositoryInterface');
        $repository->shouldReceive('getList')
            ->withAnyArgs()
            ->times($isCached ? 0 : 1)
            ->andReturn($collection);

        $cache = m::mock('Kazan\Articler\Cache\CacheInterface');
        $cache->shouldReceive('has')
            ->once()
            ->andReturn($isCached);
        $cache->shouldReceive('get')
            ->times($isCached ? 1 : 0)
            ->andReturn($collection);
        $cache->shouldReceive('put')
            ->times($isCached ? 0 : 1);

        $config = m::mock('Kazan\Articler\Config\ConfigInterface');
        $config->shouldReceive('get')->once()->andReturn(1);

        $object = $this->buildObject($repository, null, $cache, $config);

        $this->assertEquals(
            $collection,
            $object->getList('any-collection')
        );
    }

    /**
     * @dataProvider articlesListProvider
     */
    public function testGetListFromTwoToFive($isCached)
    {
        $collection = 'articles-collection';

        $repository = m::mock('Kazan\Articler\Repository\RepositoryInterface');
        $repository->shouldReceive('getList')
            ->withAnyArgs()
            ->times($isCached ? 0 : 1)
            ->andReturn($collection);

        $cache = m::mock('Kazan\Articler\Cache\CacheInterface');
        $cache->shouldReceive('has')
            ->once()
            ->andReturn($isCached);
        $cache->shouldReceive('get')
            ->times($isCached ? 1 : 0)
            ->andReturn($collection);
        $cache->shouldReceive('put')
            ->times($isCached ? 0 : 1);

        $config = m::mock('Kazan\Articler\Config\ConfigInterface');
        $config->shouldReceive('get')->once()->andReturn(1);

        $object = $this->buildObject($repository, null, $cache, $config);

        $this->assertEquals(
            $collection,
            $object->getList('two-to-five-collection')
        );
    }

    public function testGetArticleNotFound()
    {
        $repository = m::mock('Kazan\Articler\Repository\RepositoryInterface');
        $repository->shouldReceive('getArticle')->once()->andReturn(null);

        $parser = m::mock('Kazan\Articler\Parser\ParserInterface');
        $parser->shouldReceive('parse')->never();

        $cache = m::mock('Kazan\Articler\Cache\CacheInterface');
        $cache->shouldReceive('put')->never();
        $cache->shouldReceive('has')->once()->andReturn(false);

        $config = m::mock('Kazan\Articler\Config\ConfigInterface');
        $config->shouldReceive('get')->once()->andReturn(1);

        $object = $this->buildObject($repository, $parser, $cache, $config);

        $this->assertNull($object->getArticle('any-collection', 'any-slug'));
    }

    /**
     * @dataProvider articlesListProvider
     */
    public function testGetArticle($isCached)
    {
        $article = new Article('title', 'slug', 'article-content');
        $parsed = 'parsed-article-content';

        $parsedArticle = clone($article);
        $parsedArticle->setContent($parsed);

        $repository = m::mock('Kazan\Articler\Repository\RepositoryInterface');
        $repository->shouldReceive('getArticle')
            ->withAnyArgs()
            ->times($isCached ? 0 : 1)
            ->andReturn($article);

        $parser = m::mock('Kazan\Articler\Parser\ParserInterface');
        $parser->shouldReceive('parse')
            ->with($article->getContent())
            ->times($isCached ? 0 : 1)
            ->andReturn($parsed);

        $cache = m::mock('Kazan\Articler\Cache\CacheInterface');
        $cache->shouldReceive('has')
            ->once()
            ->andReturn($isCached);
        $cache->shouldReceive('get')
            ->times($isCached ? 1 : 0)
            ->andReturn($parsedArticle);
        $cache->shouldReceive('put')
            ->times($isCached ? 0 : 1);

        $config = m::mock('Kazan\Articler\Config\ConfigInterface');
        $config->shouldReceive('get')->once()->andReturn(1);

        $object = $this->buildObject($repository, $parser, $cache, $config);

        $this->assertEquals(
            $parsed,
            $object->getArticle('any-collection', 'slug')->getContent()
        );
    }

    public function articlesListProvider()
    {
        return array(
            'Object is cached' => array(
                'isCached' => true,
            ),
            'Object is not cached' => array(
                'isCached' => false,
            ),
        );
    }

    /**
     * Build an Articler instance with mocked interface injected.
     *
     * @param  RepositoryInterface  $repository
     * @param  ParserInterface      $parser
     * @param  CacheInterface       $cache
     * @param  ConfigInterface      $config
     * @return Articler
     */
    protected function buildObject(
        $repository = null, $parser = null, $cache = null, $config = null
    ) {
        if (!$repository) {
            $repository = m::mock('Kazan\Articler\Repository\RepositoryInterface');
        }

        if (!$parser) {
            $parser = m::mock('Kazan\Articler\Parser\ParserInterface');
        }

        if (!$cache) {
            $cache = m::mock('Kazan\Articler\Cache\CacheInterface');
        }

        if (!$config) {
            $config = m::mock('Kazan\Articler\Config\ConfigInterface');
        }

        return new Articler($repository, $parser, $cache, $config);
    }
}
