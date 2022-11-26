<?php

namespace Engine\Sockets;

abstract class Socket
{
    protected static $instance;

    abstract protected static function getInstance();

    abstract protected static function testConnection($instance);

}
