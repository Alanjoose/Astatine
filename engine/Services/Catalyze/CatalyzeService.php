<?php

namespace Engine\Catalyze;

interface CatalyzeService
{
    public function buildInsertStatement($table, $columnsAndValues);
    public function buildSelectStatement($table, $columns = null);
    public function buildWhereStatement($table, $keyName, $operator = "=", $keyValue);
    public function buildUpdateStatement($table, $columnsAndValues, $primaryKeyValue);
    public function buildDeleteStatement($table, $primaryKeyValue);
}
