<?php

namespace Kazan\ArticlerTests\Repository;

use Kazan\ArticlerTests\AbstractTestCase;
use Kazan\Articler\Repository\JsonStaticRepository;

use Mockery as m;

class JsonStaticRepositoryTest extends AbstractTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     *  @expectedException Kazan\Articler\Filesystem\FileNotFoundException
     */
    public function testGetListNonExistantMetadataJson()
    {
        $files = m::mock('Kazan\Articler\Filesystem\FilesystemInterface');
        $files->shouldReceive('get')
            ->atMost()
            ->once()
            ->andThrow('Kazan\Articler\Filesystem\FileNotFoundException');

        $object = $this->buildObject($files);

        $object->getList('any-collection', 3, 2);
    }

    /**
     *  @expectedException Kazan\Articler\Repository\RepositoryException
     */
    public function testGetListInvalidJsonToc()
    {
        $files = m::mock('Kazan\Articler\Filesystem\FilesystemInterface');
        $files->shouldReceive('get')
            ->atMost()
            ->once()
            ->andReturn('an-invalid-json-string');

        $object = $this->buildObject($files);

        $object->getList('any-collection', 3, 2);
    }

    public function testGetList()
    {
        $fixture = file_get_contents(__DIR__ . '/../fixtures/articles.json');

        $files = m::mock('Kazan\Articler\Filesystem\FilesystemInterface');
        $files->shouldReceive('get')
            ->atMost()
            ->once()
            ->andReturn($fixture);

        $object = $this->buildObject($files);

        $toc = $object->getList('any-collection');

        $this->assertInstanceOf(
            'Kazan\Articler\Article\Toc',
            $toc
        );

        $this->assertCount(
            5,
            $toc->getArticles(),
            'The fixture only has 5 Articles to generate'
        );
    }

    public function testGetArticle()
    {
        $fixture = file_get_contents(__DIR__ . '/../fixtures/articles.json');
        $content = 'this is the text in the article';

        $files = m::mock('Kazan\Articler\Filesystem\FilesystemInterface');
        $files->shouldReceive('get')
            ->atMost()
            ->twice()
            ->andReturnValues(array($fixture, $content));

        $object = $this->buildObject($files);

        $article = $object->getArticle('fixtured', 'slug-article-4');

        $this->assertInstanceOf(
            'Kazan\Articler\Article\Article',
            $article
        );

        $this->assertEquals(
            $content,
            $article->getContent()
        );
    }

    public function testArticleNotFound()
    {
        $fixture = file_get_contents(__DIR__ . '/../fixtures/articles.json');

        $files = m::mock('Kazan\Articler\Filesystem\FilesystemInterface');
        $files->shouldReceive('get')
            ->once()
            ->andReturn($fixture);

        $object = $this->buildObject($files);

        $this->assertNull(
            $object->getArticle('fixtured', 'slug-article-non-existant')
        );
    }

    /**
     * Build a JsonStaticRepository instance with mocked interface injected.
     *
     * @param  \Kazan\Articler\Filesystem\FilesystemInterface  $files
     * @return JsonStaticRepository
     */
    protected function buildObject($files, $path = '/path/to')
    {
        return new JsonStaticRepository($files, $path);
    }
}
