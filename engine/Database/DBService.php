<?php

namespace Engine\Database;

interface DBService
{
    public static function startTransaction();
    public static function makeCommit();
    public static function makeRollback();
    public static function table($table);

    public function save($columnsAndValues);
    public function select($columns);
    public function find($id);
    public function first($columns);
    public function last($columns);
    public function exists();
    public function get($columns);
    public function whereAnd($keyName, $operator, $keyValue);
    public function update($columnsAndValues, $primaryKeyValue);
    public function delete($primaryKeyValue);
}
