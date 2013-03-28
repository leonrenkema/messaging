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
    
    //The default lifespan for workers that have not implemented their own
    //The lifespan is set in message count, so this is the amount of messages the worker will process before restarting itself
    //restarting itself frees up memory and resources;
    const DEFAULT_LIFESPAN = 100;
    
    const MESSAGE_RESTARTING = "This Worker is restarting since it has reached its end of life. It will be back up shortly";
    
    /**
     * Blocking call that fires the Task every time a message comes in.
     * 
     * @param $lifespan; If empty the default lifespan is used. When the lifespan is reached the connection is reset.
     */
    public function start($lifespan = null) {

        //set the default lifespan if no lifespan has been given
        if($lifespan == null){
            $lifespan = self::DEFAULT_LIFESPAN;
        }
        
        //set the amount of processed messages go 0.
        $messagesProcessed = 0;
        while(count($this->channel->callbacks)) {
            //set the message +1 (its the first, 2nd, 3rd, etc message)
            $messagesProcessed+=1;
            
            //check if the lifespan has been reached
            if($lifespan >= $messagesProcessed){
                //if not we wait for another message
                $this->channel->wait();
            } else {
                //once it has we close the connection.
                $this->channel->close(0, self::MESSAGE_RESTARTING);
                echo self::MESSAGE_RESTARTING;
                //exit the php process so we can release the resources
                exit;
            }
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
        if(defined($handlerClassName."::PREFETCH_SIZE")){
           $prefetchSize = $handlerClassName::PREFETCH_SIZE;
        }
        
        //check if the class name which is called here has implemented its own prefetch count
        if(defined($handlerClassName."::PREFETCH_COUNT")){
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