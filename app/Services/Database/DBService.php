<?php

namespace App\Services\Database;

interface DBService
{
    public static function startTransaction();
    public static function makeCommit();
    public static function makeRollback();
    public static function table(string $table);

    public function save(array $columnsAndValues);
    public function select(?array $columns);
    public function find(int $id);
    public function where(string $keyName, ?string $operator, mixed $keyValue);
    public function update(array $columnsAndValues, mixed $primaryKeyValue);
    public function delete(mixed $primaryKeyValue);

}