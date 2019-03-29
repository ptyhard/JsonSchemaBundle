<?php

namespace Ptyhard\JsonSchemaBundle\Tests\Unit\Generator\Property\Generators;


use PHPUnit\Framework\TestCase;
use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;
use Ptyhard\JsonSchemaBundle\Generator\Property\Generators\ObjectGenerator;
use Ptyhard\JsonSchemaBundle\Generator\Schema\GeneratorInterface;

class ObjectGeneratorTest extends TestCase
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
            '$schema' => 'a',
            'a' => 'b'
        ];

        $this->schemaGenerator->generate($data['class'])
            ->willReturn($data);

        $property = $this->prophesize(PropertyInterface::class);
        $property->toArray()
            ->willReturn($data);

        $objectGenerator = new ObjectGenerator($this->schemaGenerator->reveal());
        $actual = $objectGenerator->generate($property->reveal());

        $this->assertSame(['a' => 'b'], $actual);



    }

}