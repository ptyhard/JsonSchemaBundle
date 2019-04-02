<?php

namespace Ptyhard\JsonSchemaBundle\Generator\Schema\Generators;

use Doctrine\Common\Annotations\Reader;
use Ptyhard\JsonSchemaBundle\Annotations\JsonSchemaInterface;
use Ptyhard\JsonSchemaBundle\Annotations\SchemaClass;
use Ptyhard\JsonSchemaBundle\Exception\GeneratorException;
use Ptyhard\JsonSchemaBundle\Generator\Property\PropertyGeneratorResolver;
use Ptyhard\JsonSchemaBundle\Generator\Schema\SchemaGeneratorInterface;

class ObjectSchemaGenerator implements SchemaGeneratorInterface
{
    public function generate(JsonSchemaInterface $schema): array
    {
        assert($schema instanceof SchemaClass);
        return $schema->toArray();
    }

    public function supported(JsonSchemaInterface $schema): bool
    {
        return $schema instanceof SchemaClass;
    }


}