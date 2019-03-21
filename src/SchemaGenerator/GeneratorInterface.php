<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\SchemaGenerator;

use Ptyhard\JsonSchemaBundle\Exception\GeneratorException;

interface GeneratorInterface
{
    /**
     * @param string $class format class name
     *
     * @return array schema array
     *
     * @throws GeneratorException
     */
    public function generate(string $class): array;
}
