<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator\Schema\Generators;

use Psr\SimpleCache\CacheInterface;
use Ptyhard\JsonSchemaBundle\Annotations\JsonSchemaInterface;
use Ptyhard\JsonSchemaBundle\Annotations\SchemaFile;
use Ptyhard\JsonSchemaBundle\Generator\Schema\SchemaGeneratorInterface;

class FileGenerator implements SchemaGeneratorInterface
{
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var string
     */
    private $baseFilePath;

    public function __construct(CacheInterface $cache, string $baseFilePath)
    {
        $this->cache = $cache;
        $this->baseFilePath = $baseFilePath;
    }

    public function generate(JsonSchemaInterface $schema): array
    {
        \assert($schema instanceof SchemaFile);
        $path = $this->baseFilePath . '/' . $schema->getFile();
        $key = 'json_schema_' . md5($path);

        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        $this->cache->set($key, $data);

        return $data;
    }

    public function supported(JsonSchemaInterface $schema): bool
    {
        return $schema instanceof SchemaFile;
    }
}
