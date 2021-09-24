<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator\Property\Generators;

use Ptyhard\JsonSchemaBundle\Annotations\Property\CollectionProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;
use Ptyhard\JsonSchemaBundle\Generator\ClassGeneratorInterface;
use Ptyhard\JsonSchemaBundle\Generator\Property\PropertyGeneratorInterface;

class CollectionPropertyGenerator implements PropertyGeneratorInterface
{
    private ClassGeneratorInterface $generator;

    public function __construct(ClassGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public function generate(PropertyInterface $property): array
    {
        $data = $property->toArray();
        $data['items'] = $this->generator->generate($data['class']);
        unset($data['items']['$schema'], $data['class']);

        return $data;
    }

    public function supported(string $name): bool
    {
        return CollectionProperty::class === $name;
    }
}
