<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Functional\FileWriter;

use Doctrine\Common\Annotations\AnnotationReader;
use PHPUnit\Framework\TestCase;
use Ptyhard\JsonSchemaBundle\Annotations\Property\ArrayProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Property\NumberProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Property\StringProperty;
use Ptyhard\JsonSchemaBundle\FileWriter\Writer;
use Ptyhard\JsonSchemaBundle\Generator\ClassGenerator;
use Ptyhard\JsonSchemaBundle\Generator\ClassGeneratorInterface;
use Ptyhard\JsonSchemaBundle\Generator\Property\Generators\CollectionPropertyGenerator;
use Ptyhard\JsonSchemaBundle\Generator\Property\Generators\DefaultPropertyGenerator;
use Ptyhard\JsonSchemaBundle\Generator\Property\Generators\ObjectPropertyGenerator;
use Ptyhard\JsonSchemaBundle\Generator\Property\PropertyGeneratorResolver;
use Ptyhard\JsonSchemaBundle\Generator\Schema\Generators\FileGenerator;
use Ptyhard\JsonSchemaBundle\Generator\Schema\Generators\ObjectSchemaGenerator;
use Ptyhard\JsonSchemaBundle\Generator\Schema\SchemaGeneratorResolver;
use Ptyhard\JsonSchemaBundle\Tests\Schema\User;
use Symfony\Component\Filesystem\Filesystem;

class WriterTest extends TestCase
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var ClassGeneratorInterface
     */
    private $classGenerator;

    protected function setUp(): void
    {
        $this->filesystem = new Filesystem();

        $this->classGenerator = new ClassGenerator(new AnnotationReader());
        $defaultGenerator = new DefaultPropertyGenerator([StringProperty::class, NumberProperty::class, ArrayProperty::class]);
        $collectionGenerator = new CollectionPropertyGenerator($this->classGenerator);
        $objectPropertyGenerator = new ObjectPropertyGenerator($this->classGenerator);

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

        $this->classGenerator->setPropertyGeneratorResolver($propertyGeneratorResolver);
        $this->classGenerator->setSchemaGeneratorResolver($schemaGeneratorResolver);
    }

    public function tearDown(): void
    {
        $this->filesystem->remove(__DIR__ . '/user.json');
    }

    public function testWrite(): void
    {
        $writer = new Writer($this->filesystem, $this->classGenerator, __DIR__);
        $writer->write(User::class);

        self::assertTrue($this->filesystem->exists(__DIR__ . '/user.json'));
    }
}
