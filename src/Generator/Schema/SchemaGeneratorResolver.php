<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator\Schema;

use Ptyhard\JsonSchemaBundle\Annotations\JsonSchemaInterface;
use Ptyhard\JsonSchemaBundle\Exception\SchemaGeneratorException;

class SchemaGeneratorResolver
{
    /**
     * @var SchemaGeneratorInterface[]
     */
    private array $generators = [];

    /**
     * @param SchemaGeneratorInterface[] $generators
     */
    public function __construct(array $generators)
    {
        foreach ($generators as $generator) {
            $this->addGenerator($generator);
        }
    }

    final public function addGenerator(SchemaGeneratorInterface $generator): void
    {
        $this->generators[] = $generator;
    }

    final public function resolve(JsonSchemaInterface $schema): SchemaGeneratorInterface
    {
        foreach ($this->generators as $generator) {
            \assert($generator instanceof SchemaGeneratorInterface);
            if ($generator->supported($schema)) {
                return $generator;
            }
        }

        throw new SchemaGeneratorException('SchedmaGeneraeter no supported');
    }
}
