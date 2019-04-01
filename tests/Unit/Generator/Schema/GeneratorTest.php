<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Unit\Generator\Schema;

use Doctrine\Common\Annotations\Reader;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Ptyhard\JsonSchemaBundle\Annotations\Property\Property;
use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;
use Ptyhard\JsonSchemaBundle\Annotations\Schema;
use Ptyhard\JsonSchemaBundle\Generator\Property\GeneratorInterface;
use Ptyhard\JsonSchemaBundle\Generator\Property\PropertyGeneratorResolver;
use Ptyhard\JsonSchemaBundle\Generator\Schema\Generator;
use Ptyhard\JsonSchemaBundle\Tests\Schema\User;

class GeneratorTest extends TestCase
{
    private $annotationReader;

    private $propertyGeneratorResolver;

    public function setUp(): void
    {
        $this->annotationReader = $this->prophesize(Reader::class);
        $this->propertyGeneratorResolver = $this->prophesize(PropertyGeneratorResolver::class);
    }

    public function testGenerate(): void
    {
        $class = User::class;

        $schema = $this->prophesize(Schema::class);
        $property = $this->prophesize(Property::class);
        $propertyGenerator = $this->prophesize(GeneratorInterface::class);

        $property->getName()
            ->willReturn('test');

        $this->annotationReader->getClassAnnotation(Argument::type(\ReflectionClass::class), Schema::class)
            ->willReturn($schema);

        $this->annotationReader->getPropertyAnnotation(Argument::type(\ReflectionProperty::class), PropertyInterface::class)
            ->willReturn($property);

        $this->propertyGeneratorResolver->resolve(Argument::any())
            ->willReturn($propertyGenerator);

        $propertyGenerator->generate($property)
            ->willReturn([]);

        $schema->toArray()
            ->willReturn([]);

        $generator = new Generator($this->annotationReader->reveal());
        $generator->setPropertyGeneratorResolver($this->propertyGeneratorResolver->reveal());
        $generator->generate($class);

        $this->annotationReader->getClassAnnotation(Argument::type(\ReflectionClass::class), Schema::class)
            ->shouldHaveBeenCalled();

        $this->annotationReader->getPropertyAnnotation(Argument::type(\ReflectionProperty::class), PropertyInterface::class)
            ->shouldHaveBeenCalled();

        $this->propertyGeneratorResolver->resolve(Argument::any())
            ->shouldHaveBeenCalled();
    }
}
