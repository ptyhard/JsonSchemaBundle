<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Functional;

use Doctrine\Common\Annotations\AnnotationReader;
use PHPUnit\Framework\TestCase;
use Ptyhard\JsonSchemaBundle\SchemaGenerator\Generator;
use Ptyhard\JsonSchemaBundle\Tests\Schema\User;

class GeneratorTest extends TestCase
{
    /**
     * @var Generator
     */
    private $generator;

    /**
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function setUp(): void
    {
        $this->generator = new Generator(new AnnotationReader());
    }

    public function testGenerateStringAnnotation(): void
    {
        $expect = [
            '$schema' => 'http://json-schema.org/draft-07/schema#',
            'required' => [
                    0 => 'id',
                ],
            'type' => 'object',
            'properties' => [
                    'id' => [
                            'type' => 'number',
                            'options' => [
                                ],
                            'minimum' => 1,
                        ],
                    'name' => [
                            'type' => 'string',
                            'options' => [
                                ],
                            'maxLength' => 20,
                            'minLength' => 1,
                            'pattern' => '^[^a-z1-9]+$',
                        ],
                ],
        ];

        $actual = $this->generator->generate(User::class);
        $this->assertIsArray($actual);
        $this->assertSame($expect, $actual);
    }
}
