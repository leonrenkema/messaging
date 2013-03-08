<?php

namespace Messaging;

class ClientFactory {
    
    /**
    * @return Client
    *
    */
    public function create($config) {
        
        if (!isset($config['type'])) {
            $config['type'] = "BasicAMQP";
        }
        
        $className = "Messaging\\" . $config['type'] . "Client";
        
        $client = new $className();
        
        $client->setConfig($config);
        
        return $client;
        
    }
}