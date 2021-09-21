<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Unit\Generator\Property\Generators;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;
use Ptyhard\JsonSchemaBundle\Generator\ClassGeneratorInterface;
use Ptyhard\JsonSchemaBundle\Generator\Property\Generators\CollectionPropertyGenerator;

class CollectionPropertyGeneratorTest extends TestCase
{
    /**
     * @var ClassGeneratorInterface|ObjectProphecy
     */
    private $schemaGenerator;

    protected function setUp(): void
    {
        $this->schemaGenerator = $this->prophesize(ClassGeneratorInterface::class);
    }

    public function testGenerate(): void
    {
        $data = [
            'class' => 'hoge',
            'type' => 'array',
        ];

        $this->schemaGenerator->generate($data['class'])
            ->willReturn(array_merge([
                '$schema' => 'hoge',
            ], $data));

        $property = $this->prophesize(PropertyInterface::class);
        $property->toArray()
            ->willReturn($data);

        $collectionGenerator = new CollectionPropertyGenerator($this->schemaGenerator->reveal());
        $actual = $collectionGenerator->generate($property->reveal());

        $this->assertSame([
            'type' => 'array',
            'items' => [
                'class' => 'hoge',
                'type' => 'array',
            ],
        ], $actual);
    }
}
