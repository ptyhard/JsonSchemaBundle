<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Schema;

use Ptyhard\JsonSchemaBundle\Annotations\Property\CollectionProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Property\NumberProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Property\ObjectProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Property\StringProperty;
use Ptyhard\JsonSchemaBundle\Annotations\SchemaClass;

/**
 * @SchemaClass(required={"id"})
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
     * @ObjectProperty
     *
     * @var Profile
     */
    private $profile;

    /**
     * @CollectionProperty(class="Ptyhard\JsonSchemaBundle\Tests\Schema\Comment")
     *
     * @var Comment[]
     */
    private $comments = [];

    /**
     * @param Comment[] $comments
     */
    public function __construct(int $id, string $name, Profile $profile, array $comments)
    {
        $this->id = $id;
        $this->name = $name;
        $this->profile = $profile;
        $this->comments = $comments;
    }
}
