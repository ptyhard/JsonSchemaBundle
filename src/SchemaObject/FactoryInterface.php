<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\SchemaObject;

interface FactoryInterface
{
    public function create(string $className, array $data);
}
