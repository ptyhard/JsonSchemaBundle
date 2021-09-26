# JsonSchemaBundle
![CI](https://github.com/ptyhard/JsonSchemaBundle/workflows/CI/badge.svg)

JsonSchema Validate For Symfony Bundle.

## Installation

```bash 
$ composer req ptyhard/json-schema-bundle "1.0.x-dev"
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
    json_file_directory: ~ # default public/json_schema    
```

## Usage

Create a json schema file

public/json_schema/user.json

```json
{
  "$schema": "http://json-schema.org/draft-2020-12/schema#",
  "title": "user data",
  "description": "test",
  "type": "object",
  "properties": {
    "id": {
      "type": "number"
    },
    "name": {
      "type": "string"
    }
  },
  "required": ["id","name"]
}

```

Create validation controller.

```php
<?php

namespace App\Controller;

use Polidog\SimpleApiBundle\Annotations\Api;
use Ptyhard\JsonSchemaBundle\Annotations\SchemaFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main', methods: 'post')]
    #[Api(200)]
    #[SchemaFile('user.json')]
    final public function index(): array
    {
        return [
            'status' => 'ok',
        ];
    }
}

```

send request.

![]("doc/request.png")
![]("doc/response.png")

