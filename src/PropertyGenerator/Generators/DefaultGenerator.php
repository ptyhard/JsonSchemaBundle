<?php

namespace Ptyhard\JsonSchemaBundle\PropertyGenerator\Generators;


use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;
use Ptyhard\JsonSchemaBundle\PropertyGenerator\GeneratorInterface;

class DefaultGenerator implements GeneratorInterface
{
    /**
     * @var array
     */
    private $supported;

    /**
     * @param array $supported
     */
    public function __construct(array $supported)
    {
        $this->supported = $supported;
    }

    public function generate(PropertyInterface $property): array
    {
        return $property->toArray();
    }

    public function supported(string $name): bool
    {
        return in_array($name, $this->supported, true);
    }


}