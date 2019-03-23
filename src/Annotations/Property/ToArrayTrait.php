<?php

namespace Ptyhard\JsonSchemaBundle\Annotations\Property;


trait ToArrayTrait
{
    public function toArray() :array
    {
        return array_merge(parent::toArray(), array_filter(get_object_vars($this) , function ($value) {
            return $value !== null;
        }));
    }
}