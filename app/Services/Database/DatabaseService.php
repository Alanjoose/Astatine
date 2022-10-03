<?php

namespace App\Services\Database;

interface DatabaseService
{
    public static function startTransaction();
    public static function makeCommit();
    public static function makeRollback();
    public static function table(string $table);

    public function save(string|array $columnsAndValues);
    public function select(string|array $columns);
    public function where(string|array $columnsAndValues);
    public function delete();
}