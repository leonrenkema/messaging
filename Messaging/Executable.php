<?php

namespace Messaging;

/**
 * Interface to define a class executable
 * 
 * @author leonrenkema
 *
 */
interface Executable {
    
    public function execute($body);
     
}