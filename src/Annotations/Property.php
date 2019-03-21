<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Annotations;

/**
 * @Annotation
 */
class Property implements JsonSchemaInterface
{
    /**
     * @var string
     */
    private $type = 'string';

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    public function __construct(array $params)
    {
        if (isset($params['value'])) {
            $this->name = $params['value'];
        }

        foreach (['type', 'name', 'description'] as $target) {
            if (isset($params[$target])) {
                $this->$target = $params[$target];
            }
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'description' => $this->description,
        ];
    }
}
