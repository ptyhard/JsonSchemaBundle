<?php

namespace Ptyhard\JsonSchemaBundle\Tests\Unit\Annotations;


use PHPUnit\Framework\TestCase;
use Ptyhard\JsonSchemaBundle\Annotations\Property\ArrayProperty;

class ArrayPropertyTest extends TestCase
{
    public function testToArray()
    {
        $data = [
            'items' => [],
            'additionalItems' => [],
            'maxItems' => 100,
            'minItems' => 10,
            'uniqueItems' => true,
            'contains' => []
        ];

        $property = new ArrayProperty($data);
        $actual = $property->toArray();
        $expected = array_merge(['type' => 'array'], $data);
        $this->assertSame($expected, $actual);
    }
}