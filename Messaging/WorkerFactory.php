<?php

namespace Messaging;

class WorkerFactory {
    
    public function create() {
        $workerAdapter = new BasicAMQPWorker();
        return $workerAdapter;
    }
}