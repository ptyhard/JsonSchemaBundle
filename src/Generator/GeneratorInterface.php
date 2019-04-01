<?php

namespace Ptyhard\JsonSchemaBundle\Generator;


interface GeneratorInterface
{
    /**
     * @param string $class
     * @return array
     */
    public function generate(string $class) :array;
}