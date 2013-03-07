<?php

use Messaging\Executable;
use Messaging\WorkerFactory;
use PhpAmqpLib\Message\AMQPMessage;

require_once '../vendor/autoload.php';


class ThumbShotTask implements Executable {
    public function execute(AMQPMessage $body) {
        
    }
}

$t = WorkerFactory::create();
$t->registerChannel('thumbshots.create', 'ThumbShotTask');
$t->start();