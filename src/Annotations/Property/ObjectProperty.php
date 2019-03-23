<?php

namespace Ptyhard\JsonSchemaBundle\Annotations\Property;

/**
 * @Annotation
 */
class ObjectProperty extends Property
{
    use ToArrayTrait;

    /**
     * @var integer
     */
    private $maxProperties;

    /**
     * @var integer
     */
    private $minProperties;

    /**
     * @var array
     */
    private $required;

    /**
     * @var array
     */
    private $properties;

    /**
     * @var array
     */
    private $patternProperties;

    /**
     * @var array
     */
    private $additionalProperties;

    /**
     * @var array
     */
    private $dependencies;

    /**
     * @var array
     */
    private $propertyNames;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $params['type'] = 'string';
        parent::__construct($params);

        foreach (array_keys(get_object_vars($this)) as $target) {
            if (isset($params[$target])) {
                $this->$target = $params[$target];
            }
        }
    }


}