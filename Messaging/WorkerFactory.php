<?php

namespace Messaging;

class WorkerFactory {
    
    
    /**
     * Create a worker according to the config.
     * 
     * @param array $config
     * @return \Messaging\BasicAMQPWorker
     */
    public function create($config) {
        
        if (!isset($config['type'])) {
            $config['type'] = "BasicAMQP";
        }
        
        $className = "Messaging\\" . $config['type'] . "Worker";
        
        $workerAdapter = new $className();
        
        $workerAdapter->setConfig($config);
        
        return $workerAdapter;
    }
}