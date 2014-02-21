<?php

namespace Messaging;

/**
 * Interface to define a class executable
 * 
 * @author leonrenkema
 *
 */
interface Executable {
    
    /**
     * @return void
     */
    public function execute($body);
     
}