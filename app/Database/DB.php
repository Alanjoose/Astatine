<?php

namespace App\Database;

use App\Providers\DBProvider as DatabaseSocket;
use App\Services\Database\DBService;
use App\Services\Builder\BuilderServiceImpl as QueryBuilder;
use PDO;
use PDOException;

/**
 * Provides a generic database handling.
 * 
 * @var $queryBuilder;
 * @var static $table
 * 
 * @method startTransaction(): bool
 * @method makeCommit(): bool
 * @method makeRollBack(): bool
 * 
 * @method table(string $table): static|string
 * @method save(array $columnsAndValues): bool
 * @method select(array $columns): array
 * @method find(int $id): object
 * @method where(string $keyName, ?string $operator, mixed $keyValue): array
 * @method update(array $columnsAndValues, string $keyName, mixed $keyValue): boll
 * @method delete(int $id): bool
 */
class DB extends DatabaseSocket implements DBService
{

    private $queryBuilder;
    private static string $table;

    public function __construct()
    {
        $this->queryBuilder = new QueryBuilder;
    }

    /**
     * Begin a database transaction.
     * 
     * @return bool
     */
    public static function startTransaction(): bool|array
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

    /**
     * Commit the database changes.
     * 
     * @return bool
     */
    public static function makeCommit(): bool|array
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

    /**
     * Rollback the database commited changes.
     * 
     * @return bool
     */
    public static function makeRollback(): bool|array
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

    /**
     * Defines the table to be handled.
     * 
     * @param string $table
     * 
     * @return static|string
     */
    public static function table(string $table): static|string
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

    /**
     * Saves a resource in database. (Assoc array required)
     * 
     * @param array $columnsAndValues
     * 
     * @return bool
     */
    public function save(array $columnsAndValues): bool|array
    {
        try
        {
            
        $statement = parent::getInstance()->prepare($this->queryBuilder
        ->buildInsertStatement(self::$table, $columnsAndValues));
        
        return $statement->execute();
        
        }
        catch(\Exception $exception)
        {
        return [
            'message' => 'An error occurred on save the resource.',
            'data' => [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]
        ];
        }
    }

    /**
     * Makes a simple query in database.
     * 
     * @param ?array $columns = null
     * 
     * @return array|null
     */
    public function select(?array $columns = null): array
    {
        try
        {
        
        $statement = $this->queryBuilder->buildSelectStatement(self::$table, $columns);
        
        return parent::getInstance()->query($statement)->fetchAll(PDO::FETCH_OBJ);

        }
        catch(\PDOException $exception)
        {
        return [
            'message' => 'An error occurred on return the resources.',
            'data' => [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]
        ];
        }
    }

    /**
     * Makes a query for a specified resource by the primary key.
     * 
     * @param int $id
     * 
     * @return object|null
     */
    public function find(int $id): object|array
    {
        try
        {

        $statement = $this->queryBuilder->buildWhereStatement(self::$table, 'id', '=', $id);

        $query = parent::getInstance()->query($statement)->fetch(PDO::FETCH_OBJ);

        if(!$query) {
        throw new \PDOException("Resource not found.");
        }

        return $query;

        }
        catch(\PDOException $exception)
        {
        return [
            'message' => 'An error occurred on find the resource.',
            'data' => [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]
        ];
        }
    }

    /**
     * Makes a conditional query in the database.
     * 
     * @param string $keyName
     * @param ?string $operator = '='
     * @param mixed $keyValue
     * 
     * @return array|null
     */
    public function where(string $keyName, ?string $operator, mixed $keyValue): array|null
    {
        try
        {

        $statement = $this->queryBuilder->buildWhereStatement(self::$table, $keyName, $operator, $keyValue);
        $query = parent::getInstance()->query($statement)->fetchAll(PDO::FETCH_OBJ);

        return count($query) > 0 ? $query : null;

        }
        catch(\PDOException $exception)
        {
        return [
            'message' => 'An error occurred on return the specified resource.',
            'data' => [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]
        ];
        }
    }

    /**
     * Update a specified resource in the database.
     * 
     * @param array $columnsAndValues
     * @param mixed $primaryKeyValue
     * 
     * @return bool
     */
    public function update(array $columnsAndValues, mixed $primaryKeyValue): bool|array
    {
        try
        {
        
        $statement = $this->queryBuilder->buildWhereStatement(self::$table, 'id', '=', $primaryKeyValue);
        $query = parent::getInstance()->query($statement)->fetch(PDO::FETCH_OBJ);
       
        if(!$query) {
        throw new \Exception("Resource not found.");
        }

        $statement = $this->queryBuilder->buildUpdateStatement(self::$table, $columnsAndValues, $primaryKeyValue);
        return parent::getInstance()->prepare($statement)->execute();

        }
        catch(\PDOException $exception)
        {
        return [
            'message' => 'An error occurred on update the specified resource.',
            'data' => [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]
        ];
        }
    }

    /**
     * Delete a specified resource in the database.
     * 
     * @param mixed $primaryKeyValue
     * 
     * @return bool
     */
    public function delete(mixed $primaryKeyValue): bool|array
    {
        try
        {

        $object = $this->find($primaryKeyValue);

        if(!$object) {
        throw new PDOException("Resource not found.");
        }

        $statement = parent::getInstance()->prepare($this->queryBuilder
        ->buildDeleteStatement(self::$table, $primaryKeyValue));

        return $statement->execute();

        }
        catch(\PDOException $exception)
        {
        return [
            'message' => 'An error occurred on delete the specified resource.',
            'data' => [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]
        ];
        }
    }

}
