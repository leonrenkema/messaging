<?php

namespace Messaging;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use PhpAmqpLib\Exception\AMQPConnectionException;

class BasicAMQPWorker extends Worker { 
    
    private $connection;
    
    private $channel;
    
    //The default prefetch size for workers that have not implemented their own
    const DEFAULT_PREFETCH_SIZE = 0;
    
    //The default prefetch size for workers that have not implemented their own
    const DEFAULT_PREFETCH_COUNT = 0;
    
    /**
     * Blocking call that fires the Task every time a message comes in.
     */
    public function start() {
        while(count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }
    
    public function registerChannel($name, $handlerClassName) {
        
        //set the default prefetch args
        $prefetchSize  = self::DEFAULT_PREFETCH_SIZE;
        $prefetchCount = self::DEFAULT_PREFETCH_COUNT;
        
        if ($this->connection == null) {
            $this->prepareConnection();
        }
        
        //check if the class name which is called here has implemented its own prefetch size
        if(defined($handlerClassName::PREFETCH_SIZE)){
           $prefetchSize = $handlerClassName::PREFETCH_SIZE;
        }
        
        //check if the class name which is called here has implemented its own prefetch count
        if(defined($handlerClassName::PREFETCH_COUNT)){
            $prefetchCount = $handlerClassName::PREFETCH_COUNT;
        }
        
        $this->setQos($prefetchSize, $prefetchCount);
        $this->channel->basic_consume($name, '', false, false, false, false, array($handlerClassName, 'execute'));
    }
    
    /**
     * Set the QoS for a channel. The last param of the basic_qos function is not implemented so we omit it here and set it to false by default.
     * By doing this we will need to set it for every connection tho
     * @param unknown_type $prefetchSize
     * @param unknown_type $prefetchCount
     */
    private function setQos($prefetchSize, $prefetchCount){
    
        $this->channel->basic_qos($prefetchSize, $prefetchCount, false);
    }
     
    protected function prepareConnection() {
        try { 
            $this->connection = new AMQPConnection($this->config['host'], $this->config['port'], $this->config['user'], $this->config['password']);

            $this->channel = $this->connection->channel();            
        } catch(AMQPConnectionException $e) {
            return null;
        } catch(AMQPRuntimeException $e2) {
            throw new ConnectionException($e2->getMessage(), $e2->getCode());
        }
    }
    
}