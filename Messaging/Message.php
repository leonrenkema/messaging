<?php

namespace Messaging;

interface Message {
    
    /**
     * @return void
     */
    public function getBody();

    /**
     * @return void
     */
    public function acknowledge();
}