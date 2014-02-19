<?php

use Messaging\ClientFactory;
require_once '../vendor/autoload.php';



$config['host'] = '';
$config['port'] = 5672;
$config['user'] = '';
$config['password'] = '';

$client = ClientFactory::create($config);

$body = array();

$client->publish('exchange', $body);
