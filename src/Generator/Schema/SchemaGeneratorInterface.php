<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator\Schema;

use Ptyhard\JsonSchemaBundle\Annotations\Schema;
use Ptyhard\JsonSchemaBundle\Exception\GeneratorException;

interface SchemaGeneratorInterface
{
    /**
     * @param string $class format class name
     *
     * @return array schema array
     *
     * @throws GeneratorException
     */
    public function generate(Schema $schema): array;

    /**
     * @param string $name
     * @return bool
     */
    public function supported(Schema $schema): bool;

}
