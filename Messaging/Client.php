<?php

namespace Messaging;

/**
*
*
*/
abstract class Client {

    protected $config;
    
    public function setConfig($config) {
        $this->config = $config;
    }
    
	/**
	* Publish a new message to an Exchange
	*
	*
	*/
    abstract public function publish($exchange, $body);

}