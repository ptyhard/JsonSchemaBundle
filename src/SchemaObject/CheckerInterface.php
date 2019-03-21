<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\SchemaObject;

interface CheckerInterface
{
    /**
     * @param mixed $object
     *
     * @return bool
     */
    public function isSchemaObject($object): bool;

    /**
     * @param string $class
     *
     * @return bool
     *
     * @throws \ReflectionException
     */
    public function isSchemaClass(string $class): bool;
}
