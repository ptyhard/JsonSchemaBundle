<?php

namespace Ptyhard\JsonSchemaBundle\Annotations\Property;


use Ptyhard\JsonSchemaBundle\Annotations\JsonSchemaInterface;

interface PropertyInterface extends JsonSchemaInterface
{
    /**
     * @return array
     */
    public function toArray() :array;
}