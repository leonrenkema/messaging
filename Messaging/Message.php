<?php

namespace Messaging;

interface Message {
    
    public function getBody();
    public function acknowledge();
}