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
     *
     * @var number
     */
    private $barthDay;

    /**
     * @StringProperty
     *
     * @var string
     */
    private $country;

    /**
     * @StringProperty
     *
     * @var string
     */
    private $address;
}
