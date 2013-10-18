<?php

namespace Kazan\Articler\Repository;

use DateTime;
use Kazan\Articler\Article\Article;
use Kazan\Articler\Article\Tag;
use Kazan\Articler\Article\Toc;
use Kazan\Articler\Filesystem\FilesystemInterface;

/**
 *
 */
class JsonStaticRepository implements RepositoryInterface
{

    /**
     * @var FileSystem
     */
    protected $files;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var array
     */
    protected $metadata = null;

    /**
     * @var Toc
     */
    protected $toc = null;

    /**
     * Construct this instance.
     *
     * @param FilesystemInterface   $files
     * @param string                $path
     */
    public function __construct(FilesystemInterface $files, $path)
    {
        $this->files = $files;
        $this->path = $path;
    }

    /**
     * @inheritdoc
     */
    public function getList($collection, $start=0, $limit=0)
    {
        if (!$this->metadata) {
            $this->metadata = $this->load($collection);
        }

        return $this->toc = $this->build($this->metadata, $start, $limit);
    }

    /**
     * Load a given collection Toc from the fileSystem.
     *
     * @param  string $collection
     * @return boolean
     */
    protected function load($collection)
    {
        $file = "{$this->path}/{$collection}.json";

        $this->metadata = json_decode($this->files->get($file), true);

        if (!$this->metadata) {
            throw new RepositoryException("Invalid JSON metadata for {$file}");
        }

        return $this->metadata;
    }

    /**
     * Build a list of articles based on metadata
     * @param  array  $metadata
     * @param  integer $start
     * @param  integer $limit
     * @return Toc
     */
    protected function build($metadata, $start=0, $limit=0)
    {
        $toc = new Toc();
        $i = 0;

        if (empty($limit)) {
            $limit = count($metadata);
        }

        foreach ($metadata as $slug => $data) {
            if ($i++ > $start + $limit) break;
            if ($i < $start) continue;

            $toc->addArticle($this->buildArticle($slug, $data));
        }

        return $toc;
    }

    /**
     * @inheritdoc
     */
    public function getArticle($collection, $id)
    {
        if (!$this->metadata) {
            $this->metadata = $this->load($collection);
        }

        if (!isset($this->metadata[$id])) {
            return null;
        }

        $item = $this->metadata[$id];

        return $this->buildArticle(
            $id,
            $item,
            $this->files->get(
                "{$this->path}/{$collection}/{$item['contents']}"
            )
        );
    }

    /**
     * @param  string   $id
     * @param  array    $metadata
     * @param  string   $content
     * @return Article
     */
    protected function buildArticle($id, $metadata, $content='')
    {
        $article = new Article();

        $article
            ->setTitle($metadata['title'])
            ->setSlug($id)
            ->setAuthor($metadata['author'])
            ->setCreated(new DateTime($metadata['created']))
            ->setContent($content)
            ->setTags($this->buildArticleTags($metadata));

        return $article;
    }

    protected function buildArticleTags($metadata)
    {
        $tags = array();

        foreach ($metadata['tags'] as $tag) {
            $tags[] = new Tag($tag);
        }

        return $tags;
    }

}
