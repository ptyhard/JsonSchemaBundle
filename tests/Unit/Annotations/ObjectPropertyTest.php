<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Unit\Annotations;

use PHPUnit\Framework\TestCase;
use Ptyhard\JsonSchemaBundle\Annotations\Property\ObjectProperty;

class ObjectPropertyTest extends TestCase
{
    public function testToArray(): void
    {
        $data = [
            'maxProperties' => 100,
            'minProperties' => 1,
            'required' => ['a', 'b'],
            'properties' => [],
            'patternProperties' => [],
            'additionalProperties' => [],
            'dependencies' => [],
            'propertyNames' => [],
        ];

        $property = new ObjectProperty($data);
        $actual = $property->toArray();
        $expected = array_merge(['type' => 'object'], $data);
        $this->assertSame($expected, $actual);
    }
}
