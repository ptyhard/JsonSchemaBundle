<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator\Property;

use Ptyhard\JsonSchemaBundle\Exception\PropertyGeneratorException;

class PropertyGeneratorResolver
{
    /**
     * @var PropertyGeneratorInterface[]
     */
    private $generators = [];

    /**
     * @param PropertyGeneratorInterface[] $generators
     */
    public function __construct(array $generators)
    {
        foreach ($generators as $generator) {
            $this->addGenerator($generator);
        }
    }

    public function addGenerator(PropertyGeneratorInterface $generator): void
    {
        $this->generators[] = $generator;
    }

    public function resolve(string $type): PropertyGeneratorInterface
    {
        foreach ($this->generators as $generator) {
            if ($generator->supported($type)) {
                return $generator;
            }
        }

        throw new PropertyGeneratorException('PropertyGenerator no supported type: ' . $type);
    }
}
