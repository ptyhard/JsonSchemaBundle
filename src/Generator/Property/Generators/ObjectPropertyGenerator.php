<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator\Property\Generators;

use Ptyhard\JsonSchemaBundle\Annotations\Property\ObjectProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;
use Ptyhard\JsonSchemaBundle\Generator\ClassGeneratorInterface;
use Ptyhard\JsonSchemaBundle\Generator\Property\PropertyGeneratorInterface;

class ObjectPropertyGenerator implements PropertyGeneratorInterface
{
    /**
     * @var ClassGeneratorInterface
     */
    private $generator;

    /**
     * @param ClassGeneratorInterface $schemaGenerator
     */
    public function __construct(ClassGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public function generate(PropertyInterface $property): array
    {
        $data = $property->toArray();
        if (isset($data['class']) && null !== $data['class']) {
            return array_filter($this->generator->generate($data['class']), function ($key) {
                return '$schema' !== $key && 'class' !== $key;
            }, ARRAY_FILTER_USE_KEY);
        }

        return $data;
    }

    public function supported(string $name): bool
    {
        return ObjectProperty::class === $name;
    }
}
