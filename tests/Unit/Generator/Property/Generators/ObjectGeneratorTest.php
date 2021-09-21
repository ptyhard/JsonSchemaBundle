<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Unit\Generator\Property\Generators;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;
use Ptyhard\JsonSchemaBundle\Generator\ClassGeneratorInterface;
use Ptyhard\JsonSchemaBundle\Generator\Property\Generators\ObjectPropertyGenerator;

class ObjectGeneratorTest extends TestCase
{
    use ProphecyTrait;

    private ObjectProphecy $classGenerator;

    protected function setUp(): void
    {
        $this->classGenerator = $this->prophesize(ClassGeneratorInterface::class);
    }

    final public function testGenerate(): void
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

        self::assertSame(['a' => 'b'], $actual);
    }
}
