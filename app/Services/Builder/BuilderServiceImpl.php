<?php

namespace App\Services\Builder;

class BuilderServiceImpl implements BuilderService
{
    public function buildInsertStatement(string $table, array $columnsAndValues): string
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
        # Add a 0 because the 'false' value isn't added by Zend engine.
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

        return (string) $statement;

        }
        catch(\Exception $exception)
        {
        return [
        'message' => 'An error occurred on build the insert statement.',
        'data' => [
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]
        ];
        }
    }

    public function buildSelectStatement(string $table, ?array $columns = null): string
    {
        try
        {

        $statement = "select ";

       if(!is_null($columns)):

        if(in_array("*", $columns)) {
        echo "The * char is redundand for specific columns, aborting query..." . PHP_EOL;
        die(1);
        }

        $finalColumns = implode(", ", $columns);
        # Verify if the column name has a number.
        if(is_numeric(filter_var($finalColumns, FILTER_SANITIZE_NUMBER_INT))) {
        echo "Numbers are not allowed in column names, aborting query..." . PHP_EOL;
        die(1);
        }

        $statement.=$finalColumns." from {$table}";
        return (string) $statement;

        else:

        $statement.="* from {$table}";
        return (string) $statement;
        
       endif;

        }
        catch(\Exception $exception)
        {
        return [
        'message' => 'An error occurred on build the insert statement.',
        'data' => [
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]
        ];
        }
    }

    public function buildWhereStatement(string $table, string $keyName, ?string $operator, mixed $keyValue): string
    {
        try
        {
        
        if(is_numeric(filter_var($keyName, FILTER_SANITIZE_NUMBER_INT))):
        
        echo "Numbers are not allowed in column names, aborting query..." . PHP_EOL;
        die(1);

        endif;

        $statement = is_null($operator) ? "select * from {$table} where {$keyName} = {$keyValue}" :
        "select * from {$table} where {$keyName} {$operator} ";

        if(is_string($keyValue)):

        $statement.="'$keyValue'";

        elseif(!$keyValue):

        $statement.="0";

        else:

        $statement.=$keyValue;

        endif;

        return $statement;

        }
        catch(\Exception $exception)
        {
        return [
        'message' => 'An error occurred on build the where statement.',
        'data' => [
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]
        ];
        }
    }

    public function buildUpdateStatement(string $table, array $columnsAndValues, mixed $primaryKeyValue): string
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

        return (string) $statement;

        }
        catch(\Exception $exception)
        {
        return [
        'message' => 'An error occurred on build the where statement.',
        'data' => [
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]
        ];
        }
    }

    public function buildDeleteStatement(string $table, mixed $primaryKeyValue): string
    {
        try
        {

        $statement = "delete from {$table} where id = {$primaryKeyValue}";

        return (string) $statement;
        
        }
        catch(\Exception $exception)
        {
        return [
        'message' => 'An error occurred on build the delete statement.',
        'data' => [
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]
        ];
        }
    }

}