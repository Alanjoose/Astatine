<?php

namespace App\Providers;

use PDO;

/**
 * Provides the database connection via PDO class.
 *
 *  @var static $instance;
 *  @method getInstance()
 */
class DBProvider
{
    public static $instance;

    /**
     * If isn't instanced, returns a new PDO connection object.
     * 
     * @return \PDO $instance
     */
    public static function getInstance():object
    {
        try
        {
            if(!isset(self::$instance)) {   
            #Load the env config file.
            $configs = include 'config/env.php';

            self::$instance = new PDO("{$configs['DATABASE_DRIVER']}:host={$configs['DATABASE_HOST']};dbname={$configs['DATABASE_NAME']}",
            $configs['DATABASE_USERNAME'], $configs['DATABASE_PASSWORD'], [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]);
                
            }
            
            return self::$instance;
        }
        catch(\Exception $exception)
        {
            return [
                'message' => 'An error occurred on get the database conncetion.',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }
}