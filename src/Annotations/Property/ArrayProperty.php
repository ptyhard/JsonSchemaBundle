<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Annotations\Property;

/**
 * @Annotation
 */
class ArrayProperty extends Property
{
    use ConstractTrait;
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
     * @var int
     */
    private $maxItems;

    /**
     * @var int
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

    public function __construct(array $params)
    {
        $params['type'] = 'array';
        parent::__construct($params);
        $this->__defaultConstract($params);
    }
}
