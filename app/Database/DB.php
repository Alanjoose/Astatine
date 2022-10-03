<?php

namespace App\Database;

use App\Providers\DBProvider;
use App\Services\Database\DatabaseService;
use BadMethodCallException;

class DB extends DBProvider implements DatabaseService
{

    public static string $table;

    public static function startTransaction()
    {
        try
        {
        return parent::getInstance()->beginTransaction();
        }
        catch(\PDOException $exception)
        {
        return [
            'message' => 'An error occurred on beggin database transaction.',
            'data' => [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]
        ];
        die(1);
        }
    }

    public static function makeCommit()
    {
        try
        {
        return parent::getInstance()->commit();
        }
        catch(\PDOException $exception)
        {
        return [
            'message' => 'An error occurred on make a database commit.',
            'data' => [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]
        ];
        die(1);
        }
    }

    public static function makeRollback()
    {
        try
        {
        return parent::getInstance()->rollBack();
        }
        catch(\PDOException $exception)
        {
        return [
            'message' => 'An error occurred on make database rollback.',
            'data' => [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]
        ];
        die(1);
        }
    }

    public static function table(string $table)
    {
        try
        {
        self::$table = $table;
        
        return new static;
        }
        catch(\Exception $exception)
        {
        return [
            'message' => 'An error occurred on handle the ' . $table . 'table.',
            'data' => [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]
        ];
        }
    }

    public function save(string|array $columnsAndValues)
    {
        
    }

    public function select(string|array $columns)
    {
        
    }

    public function where(string|array $columnsAndValues)
    {
        
    }

    public function delete()
    {
        
    }

}