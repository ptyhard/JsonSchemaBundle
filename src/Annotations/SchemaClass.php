<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Annotations;

/**
 * @Annotation
 */
class SchemaClass implements JsonSchemaInterface
{
    /**
     * @var array
     */
    private $required = [];

    /**
     * @var string
     */
    private $type = 'object';

    public function __construct(array $params)
    {
        foreach (['required'] as $target) {
            if (isset($params[$target])) {
                $this->$target = $params[$target];
            }
        }
    }

    public function toArray(): array
    {
        return [
            '$schema' => 'http://json-schema.org/draft-07/schema#',
            'required' => $this->required,
            'type' => $this->type,
        ];
    }
}
