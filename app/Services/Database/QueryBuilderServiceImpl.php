<?php

namespace App\Services\Database;

/**
 * Builds the sql statement for use in the BD class.
 * 
 * @method buildInsertStatement()
 * @method buildSelectStatement()
 * @method buildWhereStatement()
 * @method buildUpdateStatement()
 * @method buildDeleteStatement()
 */
class QueryBuilderServiceImpl implements BuilderService
{
    /**
     * Build the insert/create statement.
     * 
     * @param string $table
     * @param array $columnsAndValues
     * 
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
        'message' => 'An error occurred on build the insert statement.',
        'data' => [
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]
        ];
        }
    }

     /**
     * Build the select statement with optional columns.
     * 
     * @param string $table
     * @param ?array $columns
     * 
     * @return string
     */
    public function buildSelectStatement(string $table, ?array $columns = null): string
    {
        try
        {
        $statement = "select ";
        if(!isset($columns)):

        $statement.="* from {$table}";
        
        echo $statement;
            
        else:

        if(in_array("*", $columns)) {
            throw new \Exception("The * char is the default value for the columns. Aborting query...");
            die(1);
        }

        $finalColumns = implode(", ", $columns);
        $statement.="$finalColumns from {$table}";

        return $statement;

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
     * Build the where statement with optional operator.
     * 
     * @param string $table
     * @param string $keyName
     * @param ?string $operator
     * @param mixed $keyValue
     * 
     * @return string
     * 
     * @return string
     */
    public function buildWhereStatement(string $table, string $keyName, ?string $operator, mixed $keyValue): string
    {
        try
        {
        $statement = !isset($operator) ? "select * from {$table} where {$keyName} = " 
        : "select * from {$table} where {$keyName} {$operator} ";

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
        'message' => 'An error occurred on build the where statement.',
        'data' => [
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]
        ];
        }
    }

     /**
     * Build the update statement.
     * 
     * @param string $table
     * @param array $columnsAndValues
     * @param mixed $primaryKeyValue
     * 
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
     * Build the delete statement with the id column by default.
     * 
     * @param string $table
     * @param mixed $primaryKeyValue
     * 
     * @return string
     */
    public function buildDeleteStatement(string $table, mixed $primaryKeyValue): string
    {
        try
        {

        $statement = "delete from {$table} where id = {$primaryKeyValue}";

        return $statement;
        
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