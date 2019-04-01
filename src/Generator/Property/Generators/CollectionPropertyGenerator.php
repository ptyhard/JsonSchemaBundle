<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator\Property\Generators;

use Ptyhard\JsonSchemaBundle\Annotations\Property\CollectionProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;
use Ptyhard\JsonSchemaBundle\Generator\GeneratorInterface;
use Ptyhard\JsonSchemaBundle\Generator\Property\PropertyGeneratorInterface;

class CollectionPropertyGenerator implements PropertyGeneratorInterface
{
    /**
     * @var GeneratorInterface
     */
    private $generator;

    /**
     * @param GeneratorInterface $schemaGenerator
     */
    public function __construct(GeneratorInterface $generator)
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
