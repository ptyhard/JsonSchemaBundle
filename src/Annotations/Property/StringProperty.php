<?php

namespace Ptyhard\JsonSchemaBundle\Annotations\Property;


/**
 * @Annotation
 */
class StringProperty extends Property
{
    use ToArrayTrait;

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

}