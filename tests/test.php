<?php

require '../vendor/autoload.php';
use Restoo\Client;

$t = new Client([
  'api' => 'http://localhost:8080'
]);

$result = $t->select('tbl_module','*');

var_dump($result);
