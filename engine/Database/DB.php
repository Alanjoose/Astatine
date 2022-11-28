<?php

namespace Engine\Database;

use Engine\Catalyze\CatalyzeServiceImpl as Catalyze;
use Engine\Contracts\Database\HandleColumnValues;
use Engine\Sockets\MysqlSocket;
use PDO;
use PDOException;

class DB extends MysqlSocket implements DBService
{
    use HandleColumnValues;

    private static $table;
    
    private $catalyze;
    
    private static $statement;

    public function __construct()
    {
        $this->catalyze = new Catalyze;
    }

    public static function startTransaction()
    {
        try
        {
            return parent::getInstance()->beginTransaction();
        }
        catch (PDOException $exception) {
            return [
                'message' => 'Error on begin database transaction',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }    
    }

    public static function makeCommit()
    {
        try
        {
            return parent::getInstance()->commit();
        }
        catch(PDOException $exception)
        {
            return [
                'message' => 'Error on commit the current work on database transaction',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    public static function makeRollback()
    {
        try
        {
            return parent::getInstance()->rollBack();
        }
        catch(PDOException $exception)
        {
            return [
                'message' => 'Error on rollback the current work on database transaction',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    public static function table($table)
    {
        self::$table = $table;
        return new static;
    }

    public function save($columnsAndValues)
    {
        try
        {
            DB::startTransaction();
            self::$statement = $this->catalyze
            ->buildInsertStatement(self::$table, $columnsAndValues);
            parent::getInstance()->prepare(self::$statement)->execute();
            echo "CHEGOU!";
            return DB::makeCommit();
        }
        catch(PDOException $exception)
        {
            DB::makeRollback();
            return [
                'message' => 'Error on save data on database',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    public function select($columns = null)
    {
        try
        {
            self::$statement = $this->catalyze
            ->buildSelectStatement(self::$table, $columns);
            return parent::getInstance()->query(self::$statement)->fetchAll(PDO::FETCH_OBJ);
        }
        catch(PDOException $exception)
        {
            return [
                'message' => 'Error on make query from table '.self::$table,
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    public function get($columns = null)
    {
        try
        {
            if(!is_null($columns)) {
                self::$statement = $this->replaceColumnsOnGet($columns, self::$statement);
            }

            if(strpos(self::$statement, "where") && is_null($columns)) {
                return parent::getInstance()->query(self::$statement)->fetchAll(PDO::FETCH_OBJ);
            }

            return $this->select($columns);
        }
        catch(PDOException $exception)
        {
            return [
                'message' => 'Error on get all the columns from table '.self::$table,
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    public function where($keyName, $operator, $keyValue)
    {
        try
        {
            self::$statement = $this->catalyze
            ->buildWhereStatement(self::$table, $keyName, $operator, $keyValue);
            return parent::getInstance()->query(self::$statement)->fetchAll(PDO::FETCH_OBJ);
        }
        catch(PDOException $exception)
        {
            return [
                'message' => 'Error on find the specified resource',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    public function whereAnd($keyName, $operator, $keyValue)
    {
        try
        {
            if(strpos(self::$statement, "where")) {
                self::$statement.=" and {$keyName} {$operator} ".$this->separeValuesByType($keyValue);
                return new static;
            }

            self::$statement = $this->catalyze
            ->buildSelectStatement(self::$table, null).$this->catalyze
            ->buildMultipleWhereStatement($keyName, $operator, $keyValue);
            return new static;
        }
        catch(PDOException $exception)
        {
            return [
                'message' => 'Error on make a conditional query from table '.self::$table,
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    public function find($id)
    {
        try
        {
            self::$statement = $this->catalyze
            ->buildFindStatement(self::$table, $id);
            return parent::getInstance()->query(self::$statement)->fetch(PDO::FETCH_OBJ);
        }
        catch(PDOException $exception)
        {
            return [
                'message' => 'Error on find the specified resource from table '.self::$table,
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    public function first($columns = null)
    {
        try
        {
            self::$statement = $this->catalyze
            ->buildSelectStatement(self::$table, $columns)." limit 1";
            return parent::getInstance()->query(self::$statement)->fetch(PDO::FETCH_OBJ);
        }
        catch(PDOException $exception)
        {
            return [
                'message' => 'Error on find the specified resource from table '.self::$table,
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    public function last($columns = null)
    {
        try
        {
            self::$statement = $this->catalyze
            ->buildSelectStatement(self::$table, $columns)." order by id desc limit 1";
            return parent::getInstance()->query(self::$statement)->fetch(PDO::FETCH_OBJ);
        }
        catch(PDOException $exception)
        {
            return [
                'message' => 'Error on find the specified resource from table '.self::$table,
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    public function exists()
    {
        try
        {
            $newStatement = "select exists(".self::$statement.")";
            $result = parent::getInstance()->prepare($newStatement)
            ->execute();
            return $result->rowCount() > 0;
        }
        catch(PDOException $exception)
        {
            return [
                'message' => 'Error on check if the resource exists',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    public function update($columnsAndValues, $primaryKeyValue)
    {
        try
        {
            DB::startTransaction();
            self::$statement = $this->catalyze
            ->buildUpdateStatement(self::$table, $columnsAndValues, $primaryKeyValue);
            return parent::getInstance()->prepare(self::$statement)->execute();
            DB::makeCommit();
        }
        catch(PDOException $exception)
        {
            DB::makeRollback();
            return [
                'message' => 'Error on update the specified resource from table '.self::$table,
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    public function delete($primaryKeyValue)
    {
        try
        {
            self::$statement = $this->catalyze
            ->buildDeleteStatement(self::$table, $primaryKeyValue);
            return parent::getInstance()->prepare(self::$statement)->execute();
        }
        catch(PDOException $exception)
        {
            return [
                'message' => 'Error on delete the specified resource from table '.self::$table,
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

}
