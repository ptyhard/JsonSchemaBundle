<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator\Schema\Generators;

use Ptyhard\JsonSchemaBundle\Annotations\JsonSchemaInterface;
use Ptyhard\JsonSchemaBundle\Annotations\SchemaClass;
use Ptyhard\JsonSchemaBundle\Generator\Schema\SchemaGeneratorInterface;

class ObjectSchemaGenerator implements SchemaGeneratorInterface
{
    final public function generate(JsonSchemaInterface $schema): array
    {
        \assert($schema instanceof SchemaClass);

        return $schema->toArray();
    }

    final public function supported(JsonSchemaInterface $schema): bool
    {
        return $schema instanceof SchemaClass;
    }
}
