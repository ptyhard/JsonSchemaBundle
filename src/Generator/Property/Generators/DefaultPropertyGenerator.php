<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Generator\Property\Generators;

use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;
use Ptyhard\JsonSchemaBundle\Generator\Property\PropertyGeneratorInterface;

class DefaultPropertyGenerator implements PropertyGeneratorInterface
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
        return array_filter($property->toArray(), function ($key) {
            return 'options' !== $key;
        }, ARRAY_FILTER_USE_KEY);
    }

    public function supported(string $name): bool
    {
        return \in_array($name, $this->supported, true);
    }
}
