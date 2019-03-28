<?php

namespace Ptyhard\JsonSchemaBundle\Tests\Unit\Annotations;


use PHPUnit\Framework\TestCase;
use Ptyhard\JsonSchemaBundle\Annotations\Property\NumberProperty;

class NumberPropertyTest extends TestCase
{
    public function testToArray() :void
    {
        $data = [
            'multipleOf' => 1,
            'maximum' => 100,
            'exclusiveMaximum' => 10,
            'minimum' => 10,
            'exclusiveMinimum' => 1,
        ];

        $property = new NumberProperty($data);
        $actual = $property->toArray();
        $expected = array_merge(['type' => 'number'], $data);
        $this->assertSame($expected, $actual);
    }
}