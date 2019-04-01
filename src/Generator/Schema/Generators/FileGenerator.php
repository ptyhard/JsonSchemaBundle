<?php

namespace Ptyhard\JsonSchemaBundle\Generator\Schema\Generators;


use Psr\SimpleCache\CacheInterface;
use Ptyhard\JsonSchemaBundle\Annotations\Schema;
use Ptyhard\JsonSchemaBundle\Generator\Schema\SchemaGeneratorInterface;
use Symfony\Component\Cache\Simple\FilesystemCache;

class FileGenerator implements SchemaGeneratorInterface
{
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var string
     */
    private $baesFilePath;

    /**
     * @param FilesystemCache $cache
     * @param string $baesFilePath
     */
    public function __construct(CacheInterface $cache, string $baesFilePath)
    {
        $this->cache = $cache;
        $this->baesFilePath = $baesFilePath;
    }

    public function generate(Schema $schema) :array
    {
        $path = $this->baesFilePath . '/'. $schema->getFile();
        $key = 'json_schema_'.md5($path);

        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        $this->cache->set($key, $data);
        return $data;
    }

    public function supported(Schema $schema): bool
    {
        return $schema->getFile() !== null;
    }


}