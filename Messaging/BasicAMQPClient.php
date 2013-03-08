<?php

namespace Messaging;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use PhpAmqpLib\Exception\AMQPConnectionException;


class BasicAMQPClient extends Client { 
    
    private $connection;
    
    private $channel;
    
    /**
     * Publish a message to the exchange
     * 
     * @param string $exchange
     * @param string $body
     */
    public function publish($exchange, $body)
    {
        $msg = new AMQPMessage(json_encode($body));
        
        if ($this->channel == null) {
            $this->prepareConnection();
        }
        
        $this->channel->basic_publish($msg, $exchange);
    }
    
    private function prepareConnection() {
        try { 
            $this->connection = new AMQPConnection($this->config['host'], $this->config['port'], $this->config['user'], $this->config['password']);

            $this->channel = $this->connection->channel();
        } catch(AMQPConnectionException $e) {
            throw new ConnectionException($e->getMessage(), $e->getCode());
        } catch(AMQPRuntimeException $e2) {
            throw new ConnectionException($e2->getMessage(), $e2->getCode());
        }
    }
    
    
}