<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\SchemaObject;

class Factory implements FactoryInterface
{
    /**
     * @return mixed
     */
    public function create(string $className, array $data)
    {
        $object = new $className();
        $ref = new \ReflectionObject($object);
        foreach ($ref->getProperties() as $property) {
            if (isset($data[$property->getName()])) {
                $property->setAccessible(true);
                $property->setValue($object, $data[$property->getName()]);
            }
        }

        return $object;
    }
}
