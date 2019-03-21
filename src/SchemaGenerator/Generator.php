<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\SchemaGenerator;

use Doctrine\Common\Annotations\Reader;
use Ptyhard\JsonSchemaBundle\Annotations\Property;
use Ptyhard\JsonSchemaBundle\Annotations\Schema;
use Ptyhard\JsonSchemaBundle\Exception\GeneratorException;

class Generator implements GeneratorInterface
{
    /**
     * @var Reader
     */
    private $annotationReader;

    /**
     * @param Reader $annotationReader
     */
    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
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
            $property = $this->annotationReader->getPropertyAnnotation($propertyReflection, Property::class);
            if (null !== $property) {
                $properties[$property->getName()] = $property->toArray();
            }
        }

        return array_merge($schema->toArray(), ['properties' => $properties]);
    }
}
