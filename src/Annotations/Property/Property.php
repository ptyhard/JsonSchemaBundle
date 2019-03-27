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
    private $options = [];

    public function __construct(array $params)
    {
        if (isset($params['value'])) {
            $this->name = $params['value'];
        }

        foreach (array_keys(get_object_vars($this)) as $target) {
            if (isset($params[$target])) {
                $this->$target = $params[$target];
            }
        }
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    public function getType(): String
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $data = [];
        foreach (get_object_vars($this) as $property => $value) {
            if (('options' !== $property || 'name' !== $property) && null !== $value) {
                $data[$property] = $value;
            }
        }

        return array_merge($data, $this->options);
    }
}
