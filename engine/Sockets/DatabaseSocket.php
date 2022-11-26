<?php

namespace Engine\Sockets;

use Exception;

class DatabaseSocket
{
    protected $mysqlSocket;

    public function __construct()
    {
        $this->mysqlSocket = new MysqlSocket;
    }

    public function startConnection()
    {
        try
        {
            $databaseDriver = $_ENV['DB_DRIVER'];
            switch($databaseDriver) {
                
                case "mysql":
                    return $this->mysqlSocket->getInstance();
                    break;
                    
                    default:
                    throw new Exception("The database driver isn'\t defined in .env file.");
                    break;
                    
            }
        }
        catch(Exception $exception)
        {
            return [
                'message' => 'Error on start database connection',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }       
    }
}