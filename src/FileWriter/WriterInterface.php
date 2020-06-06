<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\FileWriter;

interface WriterInterface
{
    public function write(string $class): void;
}
