<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Unit\Generator\Property\Generators;

use PHPUnit\Framework\TestCase;
use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;
use Ptyhard\JsonSchemaBundle\Generator\ClassGeneratorInterface;
use Ptyhard\JsonSchemaBundle\Generator\Property\Generators\ObjectPropertyGenerator;

class ObjectGeneratorTest extends TestCase
{
    /**
     * @var \Prophecy\Prophecy\ObjectProphecy
     */
    private $classGenerator;

    public function setUp(): void
    {
        $this->classGenerator = $this->prophesize(ClassGeneratorInterface::class);
    }

    public function testGenerate(): void
    {
        $data = [
            'class' => 'hoge',
            '$schema' => 'a',
            'a' => 'b',
        ];

        $this->classGenerator->generate($data['class'])
            ->willReturn($data);

        $property = $this->prophesize(PropertyInterface::class);
        $property->toArray()
            ->willReturn($data);

        $objectGenerator = new ObjectPropertyGenerator($this->classGenerator->reveal());
        $actual = $objectGenerator->generate($property->reveal());

        $this->assertSame(['a' => 'b'], $actual);
    }
}
