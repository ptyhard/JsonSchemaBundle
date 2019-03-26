<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Schema;

use Ptyhard\JsonSchemaBundle\Annotations\Property\NumberProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Property\StringProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Schema;

/**
 * @Schema(required={"id"})
 */
class User
{
    /**
     * @NumberProperty(minimum=1)
     *
     * @var int
     */
    private $id;

    /**
     * @StringProperty(minLength=1, maxLength=20, pattern="^[^a-z1-9]+$")
     *
     * @var string
     */
    private $name;

    /**
     * @param int    $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}
