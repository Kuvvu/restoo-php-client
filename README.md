# PHP Client for Restoo API Server

## Installation

Install with Composer

```
composer require kuvvu/restoo-php-client
```

## Usage

```
<?php

require '../vendor/autoload.php';

use Restoo\Client;

$t = new Client([
  'api' => '' // Your Restoo API URL
]);

$result = $t->select('tbl_module','*');

```
