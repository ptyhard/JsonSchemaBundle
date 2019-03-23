<?php

namespace Ptyhard\JsonSchemaBundle\Annotations\Property;


/**
 * @Annotation
 */
class NumberProperty extends Property implements PropertyInterface
{
    use ToArrayTrait;

    /**
     * @var integer
     */
    private $multipleOf;

    /**
     * @var integer
     */
    private $maximum;

    /**
     * @var integer
     */
    private $exclusiveMaximum;

    /**
     * @var integer
     */
    private $minimum;

    /**
     * @var integer
     */
    private $exclusiveMinimum;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $params['type'] = 'number';
        parent::__construct($params);

        foreach (['multipleOf', 'maximum', 'exclusiveMaximum', 'minimum', 'exclusiveMinimum'] as $target) {
            if (isset($params[$target]) && is_numeric($params[$target])) {
                $this->$target = $params[$target];
            }
        }
    }


}