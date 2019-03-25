<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Annotations\Property;

trait ConstractTrait
{
    private function __defaultConstract(array $params): void
    {
        foreach (array_keys(get_object_vars($this)) as $target) {
            if (isset($params[$target])) {
                $this->$target = $params[$target];
            }
        }
    }
}
