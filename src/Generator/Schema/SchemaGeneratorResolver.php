<?php

namespace Ptyhard\JsonSchemaBundle\Generator\Schema;


use Ptyhard\JsonSchemaBundle\Annotations\Schema;
use Ptyhard\JsonSchemaBundle\Exception\SchemaGeneratorException;
use Ptyhard\JsonSchemaBundle\Generator\Schema\SchemaGeneratorInterface;

class SchemaGeneratorResolver
{
    /**
     * @var GeneratorInterface[]
     */
    private $generators;

    /**
     * @param GeneratorInterface[] $generators
     */
    public function __construct(array $generators)
    {
        $this->generators = $generators;
    }

    /**
     * @param Schema $schema
     * @return GeneratorInterface
     *
     * @throws SchemaGeneratorException
     */
    public function resolve(Schema $schema) :SchemaGeneratorInterface
    {
        /** @var GeneratorInterface $generator */
        foreach ($this->generators as $generator) {
            if ($generator->supported($schema)) {
                return $generator;
            }
        }

        throw new SchemaGeneratorException('SchedmaGeneraeter no supported');
    }
}