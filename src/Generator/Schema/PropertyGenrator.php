<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator\Schema;

use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;

interface PropertyGenrator
{
    public function generate(PropertyInterface $property): array;
}
