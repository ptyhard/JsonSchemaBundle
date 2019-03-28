<?php

namespace Ptyhard\JsonSchemaBundle\Generator\Property\Generators;


use Ptyhard\JsonSchemaBundle\Annotations\Property\ObjectProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;
use Ptyhard\JsonSchemaBundle\Generator\Property\GeneratorInterface as PropertyGeneratorInterface;
use Ptyhard\JsonSchemaBundle\Generator\Schema\GeneratorInterface as SchemaGeneratorInterface;


class ObjectGenerator implements PropertyGeneratorInterface
{
    /**
     * @var SchemaGeneratorInterface
     */
    private $schemaGenerator;

    /**
     * @param SchemaGeneratorInterface $schemaGenerator
     */
    public function __construct(SchemaGeneratorInterface $schemaGenerator)
    {
        $this->schemaGenerator = $schemaGenerator;
    }

    public function generate(PropertyInterface $property): array
    {
        $data = $property->toArray();
        if (isset($data['class']) && null !== $data['class']) {
            return array_filter($this->schemaGenerator->generate($data['class']), function($key) {
                return $key !== '$schema';
            }, ARRAY_FILTER_USE_KEY);
        }

        return $data;
    }

    public function supported(string $name): bool
    {
        return ObjectProperty::class === $name;
    }

}