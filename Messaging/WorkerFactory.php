<?php

namespace Messaging;

class WorkerFactory {
    
    public function create() {
        $workerAdapter = new WorkerImpl();
        return $workerAdapter;
    }
}