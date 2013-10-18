<?php

namespace Kazan\ArticlerTests\Repository;

use DateTime;
use Kazan\ArticlerTests\AbstractTestCase;
use Kazan\Articler\Article\Article;
use Kazan\Articler\Article\Tag;
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

    public function testGetListFromTwoToFive()
    {
        $fixture = file_get_contents(__DIR__ . '/../fixtures/articles.json');

        $files = m::mock('Kazan\Articler\Filesystem\FilesystemInterface');
        $files->shouldReceive('get')
            ->atMost()
            ->once()
            ->andReturn($fixture);

        $object = $this->buildObject($files);

        $toc = $object->getList('two-to-five-collection', 2, 5);

        $this->assertInstanceOf(
            'Kazan\Articler\Article\Toc',
            $toc
        );

        $this->assertCount(
            4,
            $toc->getArticles(),
            'Error getting articles from 2 to 5'
        );
    }

    public function testGetArticle()
    {
        $fixture = file_get_contents(__DIR__ . '/../fixtures/articles.json');
        $content = 'this is the text in the article';
        $slug = 'slug-article-4';

        $files = m::mock('Kazan\Articler\Filesystem\FilesystemInterface');
        $files->shouldReceive('get')
            ->atMost()
            ->twice()
            ->andReturnValues(array($fixture, $content));

        $object = $this->buildObject($files);

        $article = $object->getArticle('fixtured', $slug);

        $this->assertInstanceOf(
            'Kazan\Articler\Article\Article',
            $article
        );

        $tags = array(
            new Tag('tag1'),
            new Tag('tag2')
        );

        $expected = new Article();
        $expected
            ->setSlug($slug)
            ->setTitle('Article 4 title')
            ->setAuthor('author')
            ->setCreated(new DateTime('2013-05-03'))
            ->setContent('this is the text in the article')
            ->setTags($tags);

        $this->assertInstanceOf('DateTime', $article->getCreated());
        $this->assertEquals($expected, $article);
        $this->assertEquals($tags, $article->getTags());
        $this->assertEquals($content, $article->getContent());
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
