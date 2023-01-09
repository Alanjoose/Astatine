<?php

use Dotenv\Dotenv;

require 'vendor/autoload.php';

$env = Dotenv::createImmutable(__DIR__);
$env->load();