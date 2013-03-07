<?php

namespace Messaging;

abstract class Client {
    abstract public function publish($exchange, $body);
}