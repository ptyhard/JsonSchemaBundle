<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Annotations;

/**
 * @Annotation
 */
class Schema implements JsonSchemaInterface
{
    /**
     * @var string
     */
    private $file;

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
        foreach (['required', 'file'] as $target) {
            if (isset($params[$target])) {
                $this->$target = $params[$target];
            }
        }
    }

    /**
     * @return string
     */
    public function getFile() :string
    {
        return $this->file;
    }

    public function toArray()
    {
        return [
            '$schema' => 'http://json-schema.org/draft-07/schema#',
            'required' => $this->required,
            'type' => $this->type,
        ];
    }
}
