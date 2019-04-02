<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator\Property;

use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;

interface PropertyGeneratorInterface
{
    /**
     * @param PropertyInterface $property
     *
     * @return array
     */
    public function generate(PropertyInterface $property): array;

    /**
     * @param string $name
     *
     * @return bool
     */
    public function supported(string $name): bool;
}