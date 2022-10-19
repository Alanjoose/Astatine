<?php

namespace App\Services\Builder;


/******************************************************************************************************************
 * -----------------BUILDER SERVICE IMPLEMENTATION----------------- 
 *
 * The Builder Service implementation builds the logic to construct the statements
 * to handle the database.
 * 
 * @method public buildInsertStatement(string $table, array $columnsAndValues): string
 * @method public buildSelectStatement(string $table, ?array $columns = null): string
 * @method public buildWhereStatement(string $table, string $keyName, ?string $operator, mixed $keyValue): string 
 * @method public buildUpdateStatement(string $table, array $columnsAndValues, mixed $primaryKeyValue): string;
 * @method public buildDeleteStatement(string $table, mixed $primaryKeyValue): string
 * 
 *******************************************************************************************************************/

class BuilderServiceImpl implements BuilderService
{
    /**
     * This method builds te insert statment using the columnsAndValues assoc
     * array.
     * 
     * @param string $table
     * @param array $columnsAndValues
     * @return string
     */
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

    /**
     * This method use the columns nullable array to build the select statement.
     * 
     * @param string $table
     * @param ?array $columns
     * @return string
     */
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

    /**
     * Thid method build the 'where' statement using operator and value.
     * 
     * @param string $table
     * @param string $keyName
     * @param ?string $operator
     * @param mixed $keyValue
     * @return string
     * 
     */
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

    /**
     * This method builds the update statment using the table primary key value.
     * 
     * @param string $table
     * @param array $columnsAndValues
     * @param mixed $primaryKeyValue
     * @return string
     */
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

    /**
     * This method builds the delete statement using the table primary key value.
     * 
     * @param string $table
     * @param mixed $primaryKeyValue
     * @return string
     */
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