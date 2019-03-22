<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Annotations\Property;

/**
 * @Annotation
 */
abstract class Property implements PropertyInterface
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $enum;

    /**
     * @var mixed
     */
    private $const;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var array
     */
    private $options;


    public function __construct(array $params)
    {
        if (isset($params['value'])) {
            $this->name = $params['value'];
        }

        foreach (['type', 'name', 'description', 'title', 'const', 'enum', 'options'] as $target) {
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

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $data = [
            'type' => $this->type,
            'description' => $this->description,
        ];

        if ($this->title) {
            $data['title'] = $this->title;
        }

        if ($this->description) {
            $data['description'] = $this->description;
        }

        if ($this->enum) {
            $data['enum'] = $this->enum;
        }

        if ($this->const) {
            $data['const'] = $this->const;
        }

        return array_merge($data, $this->options);
    }
}
