<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Functional;

use Doctrine\Common\Annotations\AnnotationReader;
use PHPUnit\Framework\TestCase;
use Ptyhard\JsonSchemaBundle\Annotations\Property\ArrayProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Property\NumberProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Property\StringProperty;
use Ptyhard\JsonSchemaBundle\Generator\Generator;
use Ptyhard\JsonSchemaBundle\Generator\Property\Generators\CollectionPropertyGenerator;
use Ptyhard\JsonSchemaBundle\Generator\Property\Generators\DefaultPropertyGenerator;
use Ptyhard\JsonSchemaBundle\Generator\Property\Generators\ObjectPropertyGenerator;
use Ptyhard\JsonSchemaBundle\Generator\Property\PropertyGeneratorResolver;
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
        $defaultGenerator = new DefaultPropertyGenerator([StringProperty::class, NumberProperty::class, ArrayProperty::class]);
        $collectionGenerator = new CollectionPropertyGenerator($this->generator);
        $objectGenerator = new ObjectPropertyGenerator($this->generator);

        $resolver = new PropertyGeneratorResolver([
            $defaultGenerator,
            $collectionGenerator,
            $objectGenerator,
        ]);

        $this->generator->setPropertyGeneratorResolver($resolver);
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
                            'minimum' => 1,
                        ],
                    'name' => [
                            'type' => 'string',
                            'maxLength' => 20,
                            'minLength' => 1,
                            'pattern' => '^[^a-z1-9]+$',
                        ],
                    'profile' => [
                            'type' => 'object',
                        ],
                    'comments' => [
                            'type' => 'array',
                            'items' => [
                                    'required' => [
                                            0 => 'title',
                                            1 => 'comment',
                                        ],
                                    'type' => 'object',
                                    'properties' => [
                                            'id' => [
                                                    'type' => 'number',
                                                    'minimum' => 1,
                                                ],
                                            'title' => [
                                                    'type' => 'string',
                                                    'maxLength' => 120,
                                                    'minLength' => 1,
                                                ],
                                            'comment' => [
                                                    'type' => 'string',
                                                    'maxLength' => 255,
                                                    'minLength' => 1,
                                                ],
                                        ],
                                ],
                        ],
                ],
        ];

        $actual = $this->generator->generate(User::class);
        $this->assertIsArray($actual);
        $this->assertSame($expect, $actual);
    }
}
