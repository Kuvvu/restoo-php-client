<?php

require '../vendor/autoload.php';
use Restoo\Client;

$t = new Client([
  'header' => [
    'Content-Type: application/json'
  ],
  'api'   => 'https://menuplan.app',
  'cache' => false,
  'expires' => 30
]);

$result = $t->select('tbl_essen','*');

var_dump($result);

//$t->purgeCache();
