<?php

namespace App\Providers;

use Exception;
use PDO;

/*********************************************************
 * -----------------DB PROVIDER-----------------
 * 
 * The DB Provider returns a PDO database connection instance
 * to be used by the other modules.
 *********************************************************/
class DBProvider
{
    /**
     * Class object abstraction.
     */
    protected static $instance;

    /**
     * Loader from the db configs file.
     */
    protected static $configs;

    /**
     * If the instance isn't setted, defines how a PDO object
     * and returns it.
     * 
     * @return PDO self::$instance
     */
    protected static function getInstance(): PDO
    {
        try
        {
            self::$configs = include 'config/db.php';

            if(!isset($instance)) {

            self::$instance = new PDO(self::$configs['DATABASE_DRIVER'].':host='.self::$configs['DATABASE_HOST']
            .';dbname='.self::$configs['DATABASE_NAME'], self::$configs['DATABASE_USERNAME'], self::$configs['DATABASE_PASSWORD'],
            [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]);

            }

            return self::$instance;
        }
        catch(Exception $exception)
        {
            return [
                'message' => "Error on establish the database connection.",
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }
}