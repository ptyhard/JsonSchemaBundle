<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator\Property;

use Ptyhard\JsonSchemaBundle\Exception\PropertyGeneratorException;

class PropertyGeneratorResolver
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

    public function resolve(string $type): GeneratorInterface
    {
        /** @var GeneratorInterface $generator */
        foreach ($this->generators as $generator) {
            if ($generator->supported($type)) {
                return $generator;
            }
        }

        throw new PropertyGeneratorException('PropertyGenerator no supported type: '.$type);
    }
}
