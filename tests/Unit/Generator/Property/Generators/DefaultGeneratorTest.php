<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Unit\Generator\Property\Generators;

use PHPUnit\Framework\TestCase;
use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;
use Ptyhard\JsonSchemaBundle\Generator\Property\Generators\DefaultGenerator;

class DefaultGeneratorTest extends TestCase
{
    public function testGenerate(): void
    {
        $data = [
            'options' => ['a' => 'b'],
            'name' => 'string',
        ];

        $property = $this->prophesize(PropertyInterface::class);
        $property->toArray()
            ->willReturn($data);

        $defaultGenerator = new DefaultGenerator(['a']);
        $actual = $defaultGenerator->generate($property->reveal());
        $this->assertSame(['name' => 'string'], $actual);
    }
}
