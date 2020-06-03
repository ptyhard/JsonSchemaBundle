<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\SchemaObject;

interface CheckerInterface
{
    /**
     * @param mixed $object
     */
    public function isSchemaObject($object): bool;

    /**
     * @throws \ReflectionException
     */
    public function isSchemaClass(string $class): bool;
}
