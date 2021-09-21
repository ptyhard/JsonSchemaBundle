<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Unit\Generator\Property\Generators;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;
use Ptyhard\JsonSchemaBundle\Generator\Property\Generators\DefaultPropertyGenerator;

class DefaultPropertyGeneratorTest extends TestCase
{
    use ProphecyTrait;

    final public function testGenerate(): void
    {
        $data = [
            'options' => ['a' => 'b'],
            'name' => 'string',
        ];

        $property = $this->prophesize(PropertyInterface::class);
        $property->toArray()
            ->willReturn($data);

        $defaultGenerator = new DefaultPropertyGenerator(['a']);
        $actual = $defaultGenerator->generate($property->reveal());
        self::assertSame(['name' => 'string'], $actual);
    }
}
