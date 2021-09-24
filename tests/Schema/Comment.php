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
     */
    private int $id;

    /**
     * @StringProperty(minLength=1, maxLength=120)
     */
    private string $title;

    /**
     * @StringProperty(minLength=1, maxLength=255)
     */
    private string $comment;
}
