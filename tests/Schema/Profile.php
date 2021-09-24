<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Schema;

use Ptyhard\JsonSchemaBundle\Annotations\Property\NumberProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Property\StringProperty;
use Ptyhard\JsonSchemaBundle\Annotations\Schema;

/**
 * @Schema
 */
class Profile
{
    /**
     * @NumberProperty
     */
    private int $barthDay;

    /**
     * @StringProperty
     */
    private string $country;

    /**
     * @StringProperty
     */
    private string $address;
}
