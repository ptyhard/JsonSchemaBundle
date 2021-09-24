<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\FileWriter;

use Ptyhard\JsonSchemaBundle\Generator\ClassGeneratorInterface;
use Symfony\Component\Filesystem\Filesystem;

class Writer implements WriterInterface
{
    private Filesystem $filesystem;
    private ClassGeneratorInterface $classGenerator;
    private string $baseDir;

    public function __construct(
        Filesystem $filesystem,
        ClassGeneratorInterface $classGenerator,
        string $baseDir
    ) {
        $this->filesystem = $filesystem;
        $this->classGenerator = $classGenerator;
        $this->baseDir = $baseDir;
    }

    /**
     * @throws \JsonException
     */
    public function write(string $class): void
    {
        $schema = $this->classGenerator->generate($class);
        $filename = strtolower(substr(strrchr($class, '\\'), 1)).'.json';
        $file = $this->baseDir.\DIRECTORY_SEPARATOR.$filename;
        $json = json_encode($schema, \JSON_THROW_ON_ERROR | \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES);
        $this->filesystem->dumpFile($file, $json);
    }
}
