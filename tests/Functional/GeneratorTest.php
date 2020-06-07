<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Functional;

use Doctrine\Common\Annotations\AnnotationReader;
use PHPUnit\Framework\TestCase;
use Ptyhard\JsonSchemaBundle\Annotations\Property\ArrayProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Property\NumberProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Property\StringProperty;
use Ptyhard\JsonSchemaBundle\Generator\ClassGenerator;
use Ptyhard\JsonSchemaBundle\Generator\Property\Generators\CollectionPropertyGenerator;
use Ptyhard\JsonSchemaBundle\Generator\Property\Generators\DefaultPropertyGenerator;
use Ptyhard\JsonSchemaBundle\Generator\Property\Generators\ObjectPropertyGenerator;
use Ptyhard\JsonSchemaBundle\Generator\Property\PropertyGeneratorResolver;
use Ptyhard\JsonSchemaBundle\Generator\Schema\Generators\FileGenerator;
use Ptyhard\JsonSchemaBundle\Generator\Schema\Generators\ObjectSchemaGenerator;
use Ptyhard\JsonSchemaBundle\Generator\Schema\SchemaGeneratorResolver;
use Ptyhard\JsonSchemaBundle\Tests\Schema\User;

class GeneratorTest extends TestCase
{
    /**
     * @var ClassGenerator
     */
    private $generator;

    /**
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function setUp(): void
    {
        $this->generator = new ClassGenerator(new AnnotationReader());
        $defaultGenerator = new DefaultPropertyGenerator([StringProperty::class, NumberProperty::class, ArrayProperty::class]);
        $collectionGenerator = new CollectionPropertyGenerator($this->generator);
        $objectPropertyGenerator = new ObjectPropertyGenerator($this->generator);

        $fileGenerator = new FileGenerator('./tests');
        $objectSchemaGenerator = new ObjectSchemaGenerator();

        $propertyGeneratorResolver = new PropertyGeneratorResolver([
            $defaultGenerator,
            $collectionGenerator,
            $objectPropertyGenerator,
        ]);

        $schemaGeneratorResolver = new SchemaGeneratorResolver([
            $objectSchemaGenerator,
            $fileGenerator,
        ]);

        $this->generator->setPropertyGeneratorResolver($propertyGeneratorResolver);
        $this->generator->setSchemaGeneratorResolver($schemaGeneratorResolver);
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
