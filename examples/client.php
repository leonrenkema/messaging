<?php

use Messaging\ClientFactory;
require_once '../vendor/autoload.php';



$config['host'] = 'test.seoeffect.com';
$config['port'] = 5672;
$config['user'] = 'guest';
$config['password'] = 'guest';

$client = ClientFactory::create($config);

$body = array('campaignId' => 31412, 'url' => 'http://tweakers.net');

$client->publish('seo.thumbshots.create', $body);
