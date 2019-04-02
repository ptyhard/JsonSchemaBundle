<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator;

use Ptyhard\JsonSchemaBundle\Exception\GeneratorException;

interface GeneratorInterface
{
    /**
     * @param string $class
     *
     * @return array
     *
     * @throws GeneratorException
     */
    public function generate(string $class): array;
}
