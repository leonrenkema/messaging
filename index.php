<?php

use Messaging\Executable;
use Messaging\WorkerFactory;

require_once 'vendor/autoload.php';


class ThumbShotTask implements Executable {
    public function execute($body) {
        
    }
}

$t = WorkerFactory::create();
$t->registerChannel('thumbshots.create', 'ThumbShotTask');
$t->start();