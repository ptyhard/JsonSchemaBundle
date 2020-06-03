<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Annotations\Property;

use Ptyhard\JsonSchemaBundle\Annotations\JsonSchemaInterface;

interface PropertyInterface extends JsonSchemaInterface
{
    public function toArray(): array;
}
