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