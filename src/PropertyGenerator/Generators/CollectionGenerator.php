<?php

namespace Ptyhard\JsonSchemaBundle\PropertyGenerator\Generators;


use Ptyhard\JsonSchemaBundle\Annotations\Property\CollectionProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;
use Ptyhard\JsonSchemaBundle\PropertyGenerator\GeneratorInterface as PropertyGeneratorInterface;
use Ptyhard\JsonSchemaBundle\SchemaGenerator\GeneratorInterface as SchemaGeneratorInterface;

class CollectionGenerator implements PropertyGeneratorInterface
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
        $data['items'] = $this->schemaGenerator->generate($data['refSchema']);
        unset($data['items']['$schema'], $data['refSchema']);
        return $data;
    }

    public function supported(string $name): bool
    {
        return $name === CollectionProperty::class;
    }


}