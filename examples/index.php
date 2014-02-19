<?php

use Messaging\Executable;
use Messaging\WorkerFactory;

require_once '../vendor/autoload.php';

class ThumbShotTask implements Executable {
    public function execute($body) {
                
    }
}

$config['host'] = '';
$config['port'] = 5672;
$config['user'] = '';
$config['password'] = '';

$t = WorkerFactory::create($config);
$t->registerChannel('seo.thumbshots.log', 'ThumbShotTask');
$t->start();
