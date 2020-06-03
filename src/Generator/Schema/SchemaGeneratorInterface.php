<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator\Schema;

use Ptyhard\JsonSchemaBundle\Annotations\JsonSchemaInterface;
use Ptyhard\JsonSchemaBundle\Exception\GeneratorException;

interface SchemaGeneratorInterface
{
    /**
     * @throws GeneratorException
     */
    public function generate(JsonSchemaInterface $schema): array;

    public function supported(JsonSchemaInterface $schema): bool;
}
