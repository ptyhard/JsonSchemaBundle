<?php

namespace Ptyhard\JsonSchemaBundle\Generator\Schema\Generators;

use Doctrine\Common\Annotations\Reader;
use Ptyhard\JsonSchemaBundle\Annotations\Schema;
use Ptyhard\JsonSchemaBundle\Exception\GeneratorException;
use Ptyhard\JsonSchemaBundle\Generator\Property\PropertyGeneratorResolver;
use Ptyhard\JsonSchemaBundle\Generator\Schema\SchemaGeneratorInterface;

class ObjectSchemaGenerator implements SchemaGeneratorInterface
{
    public function generate(Schema $schema): array
    {
        return $schema->toArray();
    }

    public function supported(Schema $schema): bool
    {
        return $schema->getFile() === null;
    }


}