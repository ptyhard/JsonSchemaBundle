<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Unit\Annotations;

use PHPUnit\Framework\TestCase;
use Ptyhard\JsonSchemaBundle\Annotations\Property\StringProperty;

class PropertyTest extends TestCase
{
    public function testToArray(): void
    {
        $params = [
            'maxLength' => 10,
            'minLength' => 1,
            'pattern' => '',
        ];

        $property = new StringProperty($params);
        $actual = $property->toArray();
        $expected = array_merge(['type' => 'string'], $params);
        $this->assertSame($expected, $actual);
    }
}
