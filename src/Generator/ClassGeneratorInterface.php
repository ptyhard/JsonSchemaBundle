<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator;

use Ptyhard\JsonSchemaBundle\Exception\GeneratorException;

interface ClassGeneratorInterface
{
    /**
     * @throws GeneratorException
     */
    public function generate(string $class): array;
}
