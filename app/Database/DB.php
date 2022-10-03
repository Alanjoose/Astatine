<?php

namespace App\Database;

use App\Providers\DBProvider;
use App\Services\Database\DatabaseService;

class DB extends DBProvider implements DatabaseService
{
    public static string $table;

    public static function begginTransaction()
    {
        
    }

    public static function commit()
    {
        
    }

    public static function rollback()
    {
        
    }

    public static function table(string $table)
    {
        
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