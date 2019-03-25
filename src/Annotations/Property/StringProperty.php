<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Annotations\Property;

/**
 * @Annotation
 */
class StringProperty extends Property
{
    use ConstractTrait;
    use ToArrayTrait;

    /**
     * @var int
     */
    private $maxLength;

    /**
     * @var int
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
        $this->__defaultConstract($params);
    }
}
