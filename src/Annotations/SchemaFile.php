<?php

namespace Ptyhard\JsonSchemaBundle\Annotations;

/**
 * @Annotation
 */
class SchemaFile implements JsonSchemaInterface
{
    /**
     * @var string
     */
    private $file;

    public function __construct(array $params)
    {
        if (isset($params['value'])) {
            $this->file = $params['value'];
        }

        foreach (['file'] as $target) {
            if (isset($params[$target])) {
                $this->$target = $params[$target];
            }
        }
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

}