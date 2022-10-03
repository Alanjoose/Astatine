<?php

use Dotenv\Dotenv;

require_once __DIR__.'/vendor/autoload.php';

$env = Dotenv::createImmutable(__DIR__);
$env->load();
