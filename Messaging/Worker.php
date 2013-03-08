<?php

namespace Messaging;

/**
 * Standard worker
 * 
 * @author leonrenkema
 *
 */
abstract class Worker {
    
    protected $config;
    
    public function setConfig($config) {
        $this->config = $config;
    }
    
    /**
     * Open the connection with a messaging broker
     * 
     */
    abstract protected function prepareConnection();
    
    public function __construct() {
    
    }
    
}