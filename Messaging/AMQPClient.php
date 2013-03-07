<?php

namespace Messaging;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPRuntimeException;

class AMQPClient extends Client { 
    
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
        
        $this->channel->basic_publish($msg, $exchange);
    }
    
    public function prepareConnection() {
        try { 
            $this->connection = new AMQPConnection('test.seoeffect.com', 5672, 'guest', 'guest');
        } catch(AMQPConnectionException $e) {
            return null;
        } catch(AMQPRuntimeException $e2) {
            
        }
        
        $this->channel = $this->connection->channel();
    }
    
    
}