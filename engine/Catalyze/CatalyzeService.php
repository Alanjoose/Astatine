<?php

namespace Engine\Catalyze;

interface CatalyzeService
{
    public function buildInsertStatement($table, $columnsAndValues);
    public function buildSelectStatement($table, $columns);
    public function buildWhereStatement($keyName, $operator = "=", $keyValue);
    public function buildFindStatement($table, $id);
    public function buildUpdateStatement($table, $columnsAndValues, $primaryKeyValue);
    public function buildDeleteStatement($table, $primaryKeyValue);
}
