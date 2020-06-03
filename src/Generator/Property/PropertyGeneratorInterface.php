<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator\Property;

use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;

interface PropertyGeneratorInterface
{
    public function generate(PropertyInterface $property): array;

    public function supported(string $name): bool;
}
