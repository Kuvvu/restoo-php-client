# PHP Client for Restoo API Server

## Installation

Install with Composer

```
composer require kuvvu/restoo-php-client:dev-master
```

## Usage

Create a new Client Object

```php
use Restoo\Client;
$database = new Client(Array $parameters);
```

### Parameters

| Parameter | Type | Description |
| --- | --- | --- |
| api | String |This is the URL of the Restoo Server API. This parameter is mandatory |
| header | Array | You can define a custom Header Array for the Restoo Client Request |
| cache | boolean |If set to true all Responses will be chached for the time defined in the Paramenter "expires" |
| expires | Integer | Time in seconds until cached values expire |

Since Restoo is basically just a wrapper for MEDOO you can now use the same Syntax as you would use for MEDOO (http://medoo.in)

```php
$result = $database->select('tablename','*', ['id' => 1]);

```
## Example

```php
<?php

require '../vendor/autoload.php';

use Restoo\Client;

$database = new Client([
  'api'   => 'http://api.test',
  'header' => [
    'Content-Type: application/json',
    'X-Authorization: 3daa0716e4ad0ea433e52f490c8ddd8b'
  ],
  'cache' => true,
  'expires' => 30
]);

$result = $database->select('tablename','*', ['id' => 1]);
```


