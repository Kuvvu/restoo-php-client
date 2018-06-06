# PHP Client for Restoo API Server

## Installation

Install with Composer

```
composer require kuvvu/restoo-php-client
```

## Usage

Since Restoo is basically just a wrapper for MEDOO you can use the same Syntax as you would use for MEDOO (http://medoo.in)

```php
<?php

require '../vendor/autoload.php';

use Restoo\Client;

$t = new Client([
  'api' => '' // Your Restoo API URL
]);

$result = $t->select('tbl_module','*');

```
