<?php

namespace Messaging;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Exception\AMQPRuntimeException;

class BasicAMQPWorker extends Worker { 
    
    private $connection;
    
    private $channel;
    
    public function start() {
        while(count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }
    
    public function registerChannel($name, $handlerClassName) {
        $this->channel->basic_consume($name, '', false, false, false, false, array($handlerClassName, 'execute'));
    }
    
    public function prepareConnection() {
        try { 
            $this->connection = new AMQPConnection('192.168.178.35', 5672, 'guest', 'guest');
        } catch(AMQPConnectionException $e) {
            return null;
        } catch(AMQPRuntimeException $e2) {
            
        }
        
        $this->channel = $this->connection->channel();
    }
    
    
}