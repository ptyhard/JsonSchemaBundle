<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Unit\Annotations;

use PHPUnit\Framework\TestCase;
use Ptyhard\JsonSchemaBundle\Annotations\Property\ArrayProperty;

class ArrayPropertyTest extends TestCase
{
    final public function testToArray(): void
    {
        $data = [
            'items' => [],
            'additionalItems' => [],
            'maxItems' => 100,
            'minItems' => 10,
            'uniqueItems' => true,
            'contains' => [],
        ];

        $property = new ArrayProperty($data);
        $actual = $property->toArray();
        $expected = array_merge(['type' => 'array'], $data);
        self::assertSame($expected, $actual);
    }
}
