<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Validator;

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
        $this->schemaValidator->check((object) $value, $schema);
        if (false === $this->schemaValidator->isValid()) {
            $e = ValidationFailedException::newException($this->schemaValidator->getErrors());
            $this->schemaValidator->reset();
            throw $e;
        }
        $this->schemaValidator->reset();
    }
}
