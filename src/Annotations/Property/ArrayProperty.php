<?php

namespace Ptyhard\JsonSchemaBundle\Annotations\Property;

/**
 * @Annotation
 */
class ArrayProperty extends Property
{
    use ToArrayTrait;

    /**
     * @var array
     */
    private $items;

    /**
     * @var array
     */
    private $additionalItems;

    /**
     * @var integer
     */
    private $maxItems;

    /**
     * @var integer
     */
    private $minItems;

    /**
     * @var bool
     */
    private $uniqueItems = false;

    /**
     * @var array
     */
    private $contains;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $params['type'] = 'array';
        parent::__construct($params);

        foreach (['items', 'additionalItems', 'maxItems', 'minItems', 'uniqueItems', 'contains'] as $target) {
            if (isset($params[$target])) {
                $this->$target = $params[$target];
            }
        }
    }

}