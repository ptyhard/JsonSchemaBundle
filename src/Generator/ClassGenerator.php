<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator;

use Doctrine\Common\Annotations\Reader;
use Ptyhard\JsonSchemaBundle\Annotations\JsonSchemaInterface;
use Ptyhard\JsonSchemaBundle\Annotations\Property\Property;
use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;
use Ptyhard\JsonSchemaBundle\Exception\GeneratorException;
use Ptyhard\JsonSchemaBundle\Generator\Property\PropertyGeneratorResolver;
use Ptyhard\JsonSchemaBundle\Generator\Schema\SchemaGeneratorResolver;

class ClassGenerator implements ClassGeneratorInterface
{
    /**
     * @var Reader
     */
    private $annotationReader;

    /**
     * @var SchemaGeneratorResolver
     */
    private $schemaGeneratorResolver;

    /**
     * @var PropertyGeneratorResolver
     */
    private $propertyGeneratorResolver;

    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    public function setSchemaGeneratorResolver(SchemaGeneratorResolver $schemaGeneratorResolver): void
    {
        $this->schemaGeneratorResolver = $schemaGeneratorResolver;
    }

    public function setPropertyGeneratorResolver(PropertyGeneratorResolver $propertyGeneratorResolver): void
    {
        $this->propertyGeneratorResolver = $propertyGeneratorResolver;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(string $class): array
    {
        try {
            $object = new \ReflectionClass($class);
        } catch (\Exception $e) {
            throw new GeneratorException('reflection class error: '.$class, 0, $e);
        }

        /** @var JsonSchemaInterface $schema */
        $schema = $this->annotationReader->getClassAnnotation($object, JsonSchemaInterface::class);
        if (null === $schema) {
            throw new GeneratorException('schema class not found.');
        }

        $properties = [];
        foreach ($object->getProperties() as $propertyReflection) {
            /** @var Property $property */
            $property = $this->annotationReader->getPropertyAnnotation($propertyReflection, PropertyInterface::class);
            if (null !== $property) {
                $name = $property->getName();
                if (null === $name) {
                    $name = $propertyReflection->getName();
                    $property->setName($name);
                }
                $propertyGenerator = $this->propertyGeneratorResolver->resolve(\get_class($property));
                $properties[$name] = $propertyGenerator->generate($property);
            }
        }

        $schemaGenerator = $this->schemaGeneratorResolver->resolve($schema);

        return array_merge($schemaGenerator->generate($schema), ['properties' => $properties]);
    }
}
