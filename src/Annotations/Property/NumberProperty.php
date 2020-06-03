<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Annotations\Property;

/**
 * @Annotation
 */
class NumberProperty extends Property
{
    use ConstractTrait;
    use ToArrayTrait;

    /**
     * @var int
     */
    private $multipleOf;

    /**
     * @var int
     */
    private $maximum;

    /**
     * @var int
     */
    private $exclusiveMaximum;

    /**
     * @var int
     */
    private $minimum;

    /**
     * @var int
     */
    private $exclusiveMinimum;

    public function __construct(array $params)
    {
        $params['type'] = 'number';
        parent::__construct($params);
        $this->__defaultConstract($params);
    }
}
