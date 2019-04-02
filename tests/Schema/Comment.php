<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Schema;

use Ptyhard\JsonSchemaBundle\Annotations\Property\NumberProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Property\StringProperty;
use Ptyhard\JsonSchemaBundle\Annotations\SchemaClass;

/**
 * @SchemaClass(required={"title", "comment"})
 */
class Comment
{
    /**
     * @NumberProperty(minimum=1)
     *
     * @var int
     */
    private $id;

    /**
     * @StringProperty(minLength=1, maxLength=120)
     *
     * @var string
     */
    private $title;

    /**
     * @StringProperty(minLength=1, maxLength=255)
     *
     * @var string
     */
    private $comment;
}
