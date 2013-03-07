<?php

use Messaging\ClientFactory;
require_once '../vendor/autoload.php';

$client = ClientFactory::create();

$client->prepareConnection();

$body = array('campaignId' => 10, 'url' => 'http://fok.nl');

$client->publish('seo.thumbshots.create', $body);
