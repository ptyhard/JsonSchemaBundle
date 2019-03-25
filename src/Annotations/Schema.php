<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Annotations;

/**
 * @Annotation
 */
class Schema implements JsonSchemaInterface
{
    private $schema = 'http://json-schema.org/draft-07/schema#';

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
        foreach (['required', 'schema'] as $target) {
            if (isset($params[$target])) {
                $this->$target = $params[$target];
            }
        }
    }

    public function toArray()
    {
        return [
            '$schema' => $this->schema,
            'required' => $this->required,
            'type' => $this->type,
        ];
    }
}
