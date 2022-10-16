<?php

/*********************************************************
 *
 * -----------------ASTATINE KERNELFILE-----------------
 * 
 * This file loads the enviroment vars from the dotenv file.
 * 
 * Package: vlucas/phpdotenv
 * Url: https://packagist.org/packages/vlucas/phpdotenv
 * License: BSD 3-Clause
 * 
 ********************************************************/

use Dotenv\Dotenv;

require 'vendor/autoload.php';

$env = Dotenv::createImmutable(__DIR__);
$env->load();