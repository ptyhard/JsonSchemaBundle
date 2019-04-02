<?php

declare(strict_types=1);

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

    /**
     * @var array
     */
    private $type;

    public function __construct(array $params)
    {
        if (isset($params['value'])) {
            $this->file = $params['value'];
        }

        foreach (['file', 'type'] as $target) {
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

    public function isRequestCheck(): bool
    {
        return \in_array('request', $this->type);
    }

    public function isResponseCheck(): bool
    {
        return \in_array('response', $this->type);
    }
}
