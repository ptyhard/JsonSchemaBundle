<?php

namespace Ptyhard\JsonSchemaBundle\Tests\Unit\Annotations;


use PHPUnit\Framework\TestCase;
use Ptyhard\JsonSchemaBundle\Annotations\Property\CollectionProperty;

class CollectionPropertyTest extends TestCase
{
    public function testToArray() :void
    {
        $data = [
            'refSchema' => 'hoge',
            'maxItems' => 100,
            'minItems' => 10
        ];

        $property = new CollectionProperty($data);
        $actual = $property->toArray();
        $expected = array_merge(['type' => 'array'], $data);
        $this->assertSame($expected, $actual);
    }
}