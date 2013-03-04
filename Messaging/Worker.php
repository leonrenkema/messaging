<?php

namespace Messaging;

/**
 * 
 * 
 * @author leonrenkema
 *
 */
abstract class Worker {
    
    private $adapter;
    
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