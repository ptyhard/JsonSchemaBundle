<?php

namespace Ptyhard\JsonSchemaBundle\PropertyGenerator;


use Ptyhard\JsonSchemaBundle\Annotations\Property\PropertyInterface;

interface GeneratorInterface
{
    /**
     * @param PropertyInterface $property
     * @return array
     */
    public function generate(PropertyInterface $property) :array;

    /**
     * @param string $name
     * @return bool
     */
    public function supported(string $name) :bool ;
}