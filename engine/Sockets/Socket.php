<?php

namespace Engine\Sockets;

abstract class Socket
{
    public static $instance;

    abstract public static function getInstance();

    abstract protected static function testConnection($instance);

}
