<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\SchemaGenerator;

use Doctrine\Common\Annotations\Reader;
use Ptyhard\JsonSchemaBundle\Annotations\Property\Property;
use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;
use Ptyhard\JsonSchemaBundle\Annotations\Schema;
use Ptyhard\JsonSchemaBundle\Exception\GeneratorException;
use Ptyhard\JsonSchemaBundle\Generator\Property\PropertyGeneratorResolver;

class Generator implements GeneratorInterface
{
    /**
     * @var Reader
     */
    private $annotationReader;

    /**
     * @var PropertyGeneratorResolver
     */
    private $propertyGeneratorResolver;

    /**
     * @param Reader $annotationReader
     */
    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param PropertyGeneratorResolver $propertyGeneratorResolver
     */
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

        /** @var Schema $schema */
        $schema = $this->annotationReader->getClassAnnotation($object, Schema::class);
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
                }
                $propertyGenerator = $this->propertyGeneratorResolver->resolve(\get_class($property));
                $properties[$name] = $propertyGenerator->generate($property);
            }
        }

        return array_merge($schema->toArray(), ['properties' => $properties]);
    }
}
