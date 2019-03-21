<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Validator;

use Ptyhard\JsonSchemaBundle\Exception\ValidationFailedException;

interface ValidatorInterface
{
    /**
     * @param array $value
     * @param array $schema
     *
     * @throws ValidationFailedException
     */
    public function check(array $value, array $schema): void;
}
