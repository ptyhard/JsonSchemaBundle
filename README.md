# JsonSchemaBundle

JsonSchema Validate For Symfony Bundle.

## Installation

```bash 
$ composer req ptyhard/json-schema-bundle "dev-master"
```

Add config/bundles.php

```php
<?php

return [
...



    Ptyhard\JsonSchemaBundle\JsonSchemaBundle::class => ['all' => true]
];

```

## Introduce bundle configuration to your config file

```yaml
# config/packages/ptyhard_json_schema.yml

ptyhard_json_schema: ~
```

## Usage

Create Schema php class.

```php
<?php
// src/JsonSchema/User.php

namespace App\JsonSchema;

use Ptyhard\JsonSchemaBundle\Annotations\Schema;
use Ptyhard\JsonSchemaBundle\Annotations\Property;

/**
* @Schema(required={"id","name"})
 */
class User 
{
    /**
     * @Property("id", type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @Property("name", type="string")
     *
     * @var string
     */
    private $name;
}

```

Create controller class.

```php
<?php

namespace App\Controller;


use App\JsonSchema\User;
use Polidog\SimpleApiBundle\Annotations\Api;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class TopController
{
    /**
     * @Route("/request/check",methods={"POST"}) 
     * @Api(statusCode=200)
     *
     * @param User $user
     * @return User
     */
    public function requestCheck(User $user) :User
    {
        return  [];
    }

    /**
     * @Route("/response/check",methods={"GET"}) 
     * @Api(statusCode=200)
     *
     * @return User
     */
    public function responseCheck() :User
    {
        return new User();
    }

}
```



