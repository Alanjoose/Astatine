<?php

namespace Engine\Catalyze;

class CatalyzeServiceImpl implements CatalyzeService
{
    public function buildInsertStatement($table, $columnsAndValues)
    {
        try
        {
            $statement = "insert into {$table}(";
            $targetColumns = array();
            $targetValues = array();

            foreach($columnsAndValues as $column => $value):

            array_push($targetColumns, $column);

            if(is_string($value)) {
            array_push($targetValues, "'$value'");
            }
            else if(!$value) {
            array_push($targetValues, "0");
            }
            else {
            array_push($targetValues, $value);
            }

            endforeach;

            $finalColumns = implode(", ", $targetColumns);
            $finalValues = implode(", ", $targetValues);

            $statement.=$finalColumns.") values (".$finalValues.")";

            return $statement;

        }
        catch(\Exception $exception)
        {
            return [
            'message' => 'Error on build the insert statement.',
            'data' => [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]
            ];
        }
    }

    public function buildSelectStatement($table, $columns)
    {
        try
        {
            if(is_array($columns) && in_array("*", $columns)) {
                throw new \Exception("The * char is the default value for the columns. Aborting query...");
                die(1);
            }

            $statement = "select ";

            if(is_null($columns)) {
                $statement.="* from {$table}";
                return $statement;
            }

            $finalColumns = implode(", ", $columns);
            $statement.="$finalColumns from {$table}";

            return $statement;

        }
        catch(\Exception $exception)
        {
            return [
            'message' => 'Error on build the insert statement.',
            'data' => [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]
            ];
        }
    }

    public function buildWhereStatement($table, $keyName, $operator, $keyValue)
    {
        try
        {
            $statement = "select * from {$table} where {$keyName} {$operator} ";

            if(is_string($keyValue)) {
                $statement.="'{$keyValue}'";
            }
            else if(!$keyValue) {
                $statement.=0;
            }
            else {
                $statement.=$keyValue;
            }
            return $statement;
        }
        catch(\Exception $exception)
        {
            return [
                'message' => 'Error on make conditional query from table '.$table,
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    public function buildMultipleWhereStatement($keyName, $operator, $keyValue)
    {
        try
        {
            $statement = !isset($operator) ? " where {$keyName} = " 
            : " where {$keyName} {$operator} ";

            if(is_string($keyValue)) {
            $statement.="'$keyValue'";
            }
            else if(!$keyValue) {
            $statement.="0";
            }
            else {
            $statement.="{$keyValue}";
            }

            return $statement;

            }
            catch(\Exception $exception)
            {
            return [
            'message' => 'Error on build the where statement.',
            'data' => [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]
            ];
        }
    }

    public function buildFindStatement($table, $id)
    {
        try
        {
            if(!is_numeric($id)) {
                throw new \Exception("The id must be a numeric value");
            }
            $statement = "select * from {$table} where id = {$id}";
            return $statement;
        }
        catch(\Exception $exception)
        {
            return [
                'message' => 'Error on build the find statement',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    public function buildUpdateStatement($table, $columnsAndValues, $primaryKeyValue)
    {
         try
        {
            $statement = "update {$table} set ";

            foreach($columnsAndValues as $column => $value):
            $statement.="{$column} = ";

            if($value != end($columnsAndValues)):

            if(is_string($value)) {
            $statement.="'$value', ";
            }
            else if(!$value) {
            $statement.="0, ";
            }
            else {
            $statement.="$value, ";
            }

            else:

            if(is_string($value)) {
            $statement.="'$value'";
            }
            else if(!$value) {
            $statement.="0";
            }
            else {
            $statement.="$value";
            }

            endif;

            endforeach;

            $statement.=" where id = {$primaryKeyValue}";

            return $statement;

        }
        catch(\Exception $exception)
        {
            return [
            'message' => 'Error on build the where statement.',
            'data' => [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]
            ];
        }
    }

    public function buildDeleteStatement($table, $primaryKeyValue)
    {
        try
        {
            $statement = "delete from {$table} where id = {$primaryKeyValue}";

            return $statement;

        }
        catch(\Exception $exception)
        {
            return [
            'message' => 'Error on build the delete statement.',
            'data' => [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]
            ];
        }
    }
}
