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
    private $generators = [];

    /**
     * @param SchemaGeneratorInterface[] $generators
     */
    public function __construct(array $generators)
    {
        foreach ($generators as $generator) {
            $this->addGenerator($generator);
        }
    }

    public function addGenerator(SchemaGeneratorInterface $generator): void
    {
        $this->generators[] = $generator;
    }

    public function resolve(JsonSchemaInterface $schema): SchemaGeneratorInterface
    {
        /** @var SchemaGeneratorInterface $generator */
        foreach ($this->generators as $generator) {
            if ($generator->supported($schema)) {
                return $generator;
            }
        }

        throw new SchemaGeneratorException('SchedmaGeneraeter no supported');
    }
}
