<?php

namespace Messaging;

class ClientFactory {
    
    public function create() {
        return new AMQPClient();
    }
}