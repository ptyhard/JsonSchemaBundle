<?php

namespace Ptyhard\JsonSchemaBundle\Tests\Unit\Generator\Property\Generators;


use PHPUnit\Framework\TestCase;
use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;
use Ptyhard\JsonSchemaBundle\Generator\Property\Generators\CollectionGenerator;
use Ptyhard\JsonSchemaBundle\Generator\Schema\GeneratorInterface;

class CollectionGeneratorTest extends TestCase
{
    private $schemaGenerator;

    public function setUp(): void
    {
        $this->schemaGenerator = $this->prophesize(GeneratorInterface::class);
    }

    public function testGenerate()
    {
        $data = [
            'class' => 'hoge',
            'type' => 'array'
        ];

        $this->schemaGenerator->generate($data['class'])
            ->willReturn(array_merge([
                '$schema' => 'hoge'
            ], $data));

        $property = $this->prophesize(PropertyInterface::class);
        $property->toArray()
            ->willReturn($data);

        $collectionGenerator = new CollectionGenerator($this->schemaGenerator->reveal());
        $actual = $collectionGenerator->generate($property->reveal());

        $this->assertSame([
            'type' => 'array',
            'items' => [
                'class' => 'hoge',
                'type' => 'array'
            ]
        ], $actual);



    }
}