<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\SchemaObject;

interface ExporterInterface
{
    public function export($object): array;
}
