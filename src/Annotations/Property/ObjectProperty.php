<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Annotations\Property;

/**
 * @Annotation
 */
class ObjectProperty extends Property
{
    use ConstractTrait;
    use ToArrayTrait;

    /**
     * @var int
     */
    private $maxProperties;

    /**
     * @var int
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

    public function __construct(array $params)
    {
        $params['type'] = 'object';
        parent::__construct($params);
        $this->__defaultConstract($params);
    }
}
