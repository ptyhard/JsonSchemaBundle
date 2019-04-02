<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator\Schema;

use Ptyhard\JsonSchemaBundle\Annotations\JsonSchemaInterface;
use Ptyhard\JsonSchemaBundle\Exception\GeneratorException;

interface SchemaGeneratorInterface
{
    /**
     * @param JsonSchemaInterface $schema
     *
     * @return array
     *
     * @throws GeneratorException
     */
    public function generate(JsonSchemaInterface $schema): array;

    /**
     * @param JsonSchemaInterface $schema
     *
     * @return bool
     */
    public function supported(JsonSchemaInterface $schema): bool;
}
