<?php

namespace Messaging;

class WorkerImpl extends Worker { 
    public function start() {
        echo " [*] AMQP start";
    }
}