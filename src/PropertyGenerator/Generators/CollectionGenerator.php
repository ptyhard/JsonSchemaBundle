<?php

namespace Ptyhard\JsonSchemaBundle\PropertyGenerator\Generators;


use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;
use Ptyhard\JsonSchemaBundle\PropertyGenerator\GeneratorInterface;

class CollectionGenerator implements GeneratorInterface
{
    /**
     * @var DefaultGenerator
     */
    private $defaultGenerator;

    /**
     * @param DefaultGenerator $defaultGenerator
     */
    public function __construct(DefaultGenerator $defaultGenerator)
    {
        $this->defaultGenerator = $defaultGenerator;
    }

    public function generate(PropertyInterface $property): array
    {
        $data = $property->toArray();
        $refClass = new $data['refSchema']();
        $data['items'] = $this->defaultGenerator->generate($refClass);
        return $data;
    }

    public function supported(string $name): bool
    {
        return $name === 'collection';
    }


}