<?php

namespace Ptyhard\JsonSchemaBundle\Annotations\Property;


class StringProperty extends Property implements TypeInterface
{
    /**
     * @var integer
     */
    private $maxLength;

    /**
     * @var integer
     */
    private $minLength;

    /**
     * @var StringProperty
     */
    private $pattern;

    public function __construct(array $params)
    {
        $params['type'] = 'string';
        parent::__construct($params);

        foreach (['maxLength', 'minLength', 'pattern'] as $target) {
            if (isset($params[$target])) {
                $this->$target = $params[$target];
            }
        }

    }

    public function toArray(): array
    {
        $data = parent::toArray();

        if ($this->maxLength !== null) {
            $data['maxLength'] = $this->maxLength;
        }

        if ($this->minLength !== null) {
            $data['minLength'] = $this->minLength;
        }

        if ($this->pattern !== null) {
            $data['pattern'] = $this->pattern;
        }

        return $data;
    }

}