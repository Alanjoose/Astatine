<?php

namespace App\Services\Builder;

interface BuilderService
{
    public function buildInsertStatement(string $table, array $columnsAndValues);
    public function buildSelectStatement(string $table, ?array $columns = null);
    public function buildWhereStatement(string $table, string $keyName, ?string $operator, mixed $keyValue);
    public function buildUpdateStatement(string $table, array $columnsAndValues, mixed $primaryKeyValue);
    public function buildDeleteStatement(string $table, mixed $primaryKeyValue);
}
