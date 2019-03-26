<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Annotations\Property;

/**
 * @Annotation
 */
class CollectionProperty extends Property
{
    use ConstractTrait;
    use ToArrayTrait;

    /**
     * @var string
     */
    private $refSchema;

    /**
     * @var int
     */
    private $maxItems;

    /**
     * @var int
     */
    private $minItems;

    public function __construct(array $params)
    {
        $params['type'] = 'array';
        parent::__construct($params);
        $this->__defaultConstract($params);
    }
}
