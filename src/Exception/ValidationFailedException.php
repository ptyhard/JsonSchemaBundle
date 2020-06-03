<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Exception;

class ValidationFailedException extends \RuntimeException implements JsonSchemaBundleException
{
    /**
     * @var array
     */
    private $errors;

    public static function newException(array $errors)
    {
        $e = new self(); // TODO error message.
        $e->errors = $errors;

        return $e;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
