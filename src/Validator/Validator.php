<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Validator;

use JsonSchema\Constraints\Constraint;
use Ptyhard\JsonSchemaBundle\Exception\ValidationFailedException;

class Validator implements ValidatorInterface
{
    /**
     * @var \JsonSchema\Validator
     */
    private $schemaValidator;

    public function __construct()
    {
        $this->schemaValidator = new \JsonSchema\Validator();
    }

    public function check(array $value, array $schema): void
    {
        $object = (object) $value;
        $this->schemaValidator->validate($object, $schema, Constraint::CHECK_MODE_COERCE_TYPES | Constraint::CHECK_MODE_TYPE_CAST);
        if (false === $this->schemaValidator->isValid()) {
            $e = ValidationFailedException::newException($this->schemaValidator->getErrors());
            $this->schemaValidator->reset();
            throw $e;
        }
        $this->schemaValidator->reset();
    }
}
