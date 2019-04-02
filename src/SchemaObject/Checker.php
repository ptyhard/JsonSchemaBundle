<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\SchemaObject;

use Doctrine\Common\Annotations\Reader;
use Ptyhard\JsonSchemaBundle\Annotations\JsonSchemaInterface;

class Checker implements CheckerInterface
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function isSchemaObject($object): bool
    {
        if (false === \is_object($object)) {
            return false;
        }

        $ref = new \ReflectionObject($object);

        return null !== $this->reader->getClassAnnotation($ref, JsonSchemaInterface::class);
    }

    public function isSchemaClass(string $class): bool
    {
        $ref = new \ReflectionClass($class);

        return null !== $this->reader->getClassAnnotation($ref, JsonSchemaInterface::class);
    }
}
