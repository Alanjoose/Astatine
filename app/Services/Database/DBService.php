<?php

namespace App\Services\Database;

/******************************************************************************************************************
 * -----------------DB SERVICE----------------- 
 *
 * The DB Service defines the method to be implemented
 * on the DB class using the query builder params.
 * 
 * @method public startTransaction(): bool|array
 * @method public makeCommit(): bool|array
 * @method public makeRollback(): bool|array
 * @method public table(string $table): static|string
 * @method public save(array $columnsAndValues): bool|array
 * @method public select(array $columns): array
 * @method public find(int $id): object|array
 * @method public where(string $keyName, ?string $operator, mixed $keyValue): array|null
 * @method public update(array $columnsAndValues, mixed $primaryKeyValue): bool|array
 * @method public delete(mixed $primaryKeyValue): bool|array
 *******************************************************************************************************************/
interface DBService
{
    public static function startTransaction(): bool|array;
    public static function makeCommit(): bool|array;
    public static function makeRollback(): bool|array;
    public static function table(string $table): static|string;

    public function save(array $columnsAndValues): bool|array;
    public function select(?array $columns): array;
    public function find(int $id): object|array;
    public function where(string $keyName, ?string $operator, mixed $keyValue): array|null;
    public function update(array $columnsAndValues, mixed $primaryKeyValue): bool|array;
    public function delete(mixed $primaryKeyValue): bool|array;
}
