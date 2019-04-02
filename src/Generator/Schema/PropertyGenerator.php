<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator\Schema;

use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;

interface PropertyGenerator
{
    public function generate(PropertyInterface $property): array;
}
