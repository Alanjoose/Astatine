<?php

function getFromEnv($key)
{
    return $_ENV[$key];
}

function db($key)
{
    return $_ENV['DB_'.$key];
}

function app($key)
{
    return $_ENV['APP_'.$key];
}

function config($keyDotValue)
{
    $separatedValues = explode('.', $keyDotValue);
    $configFile = include_once 'config/'.$separatedValues[0].'.php';
    return $configFile[strtoupper(end($separatedValues))];
}