<?php

namespace Engine\Sockets;

use Exception;
use PDO;
use PDOException;

class MysqlSocket extends Socket
{
    public static $instance;

    public static function getInstance()
    {
        try
        {

            $config = include('config/database.php');
            if(!isset(self::$instance)) {
                self::$instance = new PDO("mysql:host={$config['DB_HOST']};dbname={$config['DB_NAME']}",
                $config['DB_USERNAME'], $config['DB_PASSWORD'], [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]);
                self::testConnection(self::$instance);
            }
            return self::$instance;
        }
        catch(PDOException $exception)
        {
            return [
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ];
        }
        catch(Exception $exception)
        {
            return [
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'class' => MysqlSocket::class
            ];
        }
    }

    protected static function testConnection($instance)
    {
        if(!($instance instanceof PDO)) {
            throw new Exception("Error on get the Mysql connection instance.", 001);
        }
        return true;
    }
}
