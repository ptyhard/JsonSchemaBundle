# JsonSchemaBundle
![CI](https://github.com/ptyhard/JsonSchemaBundle/workflows/CI/badge.svg)

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
    use_jms_serializer: true # default true
    json_file_directory: ~ # default null
    json_write_directory: # default null
    
```

## Usage

Create Schema php class.

```php
<?php
// src/JsonSchema/User.php

namespace App\JsonSchema;

use Ptyhard\JsonSchemaBundle\Annotations\SchemaClass;
use Ptyhard\JsonSchemaBundle\Annotations\Property;

/**
* @SchemaClass(required={"id","name"})
 */
class User 
{
    /**
     * @Property\NumberProperty("id")
     *
     * @var int
     */
    private $id;

    /**
     * @Property\StringProperty("name")
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

## Generate object to json schema file.
If you need json schema file, can use generate command.

```bash
$ bin/console json-schema:generate:file
```
