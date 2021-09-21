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
     * @var ?CacheInterface
     */
    private $cache;

    /**
     * @var string
     */
    private $baseFilePath;

    public function __construct(string $baseFilePath)
    {
        $this->baseFilePath = $baseFilePath;
    }

    public function setCache(CacheInterface $cache): void
    {
        $this->cache = $cache;
    }

    public function generate(JsonSchemaInterface $schema): array
    {
        \assert($schema instanceof SchemaFile);
        $path = $this->baseFilePath.'/'.$schema->getFile();
        $key = 'json_schema_'.md5($path);

        $cached = $this->getCacheData($key);
        if (null !== $cached) {
            return $cached;
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        $this->setCacheData($key, $data);

        return $data;
    }

    public function supported(JsonSchemaInterface $schema): bool
    {
        return $schema instanceof SchemaFile;
    }

    private function getCacheData(string $key): ?array
    {
        if (null === $this->cache || !$this->cache->has($key)) {
            return null;
        }

        return $this->cache->get($key);
    }

    private function setCacheData(string $key, array $data): void
    {
        if (null !== $this->cache) {
            $this->cache->set($key, $data);
        }
    }
}
