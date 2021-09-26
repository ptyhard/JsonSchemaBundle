<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Annotations;

#[\Attribute]
class SchemaFile implements JsonSchemaInterface
{
    private string $file;

    /**
     * @var string[] request|response
     */
    private array $type;

    /**
     * @param string $file
     * @param string[] $type
     */
    public function __construct(string $file, array $type = ['request'])
    {
        $this->file = $file;
        $this->type = $type;
    }


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
