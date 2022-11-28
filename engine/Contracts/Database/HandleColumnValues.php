<?php

namespace Engine\Contracts\Database;

trait HandleColumnValues
{
    private function separeValuesByType($value)
    {
        if(is_string($value)) {
            return "'{$value}'";
        }
        else if(!$value) {
            return 0;
        }
        else {
            return $value;
        }
    }

    private function replaceColumnsOnGet($columns, $statement)
    {
        $arrayInString = implode(", ", $columns);
        $replace = str_replace("*", $arrayInString, $statement);
        return $replace;
    }
}
