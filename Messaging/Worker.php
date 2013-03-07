<?php

namespace Messaging;

/**
 * Standard worker
 * 
 * @author leonrenkema
 *
 */
abstract class Worker {
    
    private $adapter;
    
    abstract function prepareConnection();
    

    public function __construct() {
        $this->prepareConnection();
    }
    
    
    public function setAdapter($adapter) {
        $this->adapter = $adapter;
    }
    
    public function registerChannel($name, $class) {
        $task = new $class;
        
        if ($task instanceof Executable) {
            $task->execute("");
        }
    }
}