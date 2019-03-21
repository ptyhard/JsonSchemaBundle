<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\SchemaObject;

class Exporter implements ExporterInterface
{
    public function export($object): array
    {
        $refObject = new \ReflectionObject($object);
        $data = [];
        foreach ($refObject->getProperties() as $property) {
            $property->setAccessible(true);
            $data[$property->getName()] = $property->getValue($object);
        }

        return $data;
    }
}
