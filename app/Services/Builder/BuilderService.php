<?php

namespace App\Services\Builder;

/******************************************************************************************************************
 * -----------------BUILDER SERVICE----------------- 
 *
 * The Builder Service defines the methods to be implemented
 * on the query builder, inluding the params.
 * 
 * @method public buildInsertStatement(string $table, array $columnsAndValues): string
 * @method public buildSelectStatement(string $table, ?array $columns = null): string
 * @method public buildWhereStatement(string $table, string $keyName, ?string $operator, mixed $keyValue): string 
 * @method public buildUpdateStatement(string $table, array $columnsAndValues, mixed $primaryKeyValue): string;
 * @method public buildDeleteStatement(string $table, mixed $primaryKeyValue): string
 * 
 *******************************************************************************************************************/
interface BuilderService
{
    public function buildInsertStatement(string $table, array $columnsAndValues): string;
    public function buildSelectStatement(string $table, ?array $columns = null): string;
    public function buildWhereStatement(string $table, string $keyName, ?string $operator, mixed $keyValue): string;
    public function buildUpdateStatement(string $table, array $columnsAndValues, mixed $primaryKeyValue): string;
    public function buildDeleteStatement(string $table, mixed $primaryKeyValue): string;
}
