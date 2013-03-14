<?php

namespace Messaging;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use PhpAmqpLib\Exception\AMQPConnectionException;

class BasicAMQPWorker extends Worker { 
    
    private $connection;
    
    private $channel;
    
    /**
     * Blocking call that fires the Task every time a message comes in.
     */
    public function start() {
        while(count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }
    
    public function registerChannel($name, $handlerClassName) {
        
        if ($this->connection == null) {
            $this->prepareConnection();
        }
        
        $this->channel->basic_consume($name, '', false, false, false, false, array($handlerClassName, 'execute'));
    }
    
    protected function prepareConnection() {
        try { 
            $this->connection = new AMQPConnection($this->config['host'], $this->config['port'], $this->config['user'], $this->config['password']);

            $this->channel = $this->connection->channel();
            $this->channel->basic_qos(10, 10);
            
        } catch(AMQPConnectionException $e) {
            return null;
        } catch(AMQPRuntimeException $e2) {
            throw new ConnectionException($e2->getMessage(), $e2->getCode());
        }
    }
    
}