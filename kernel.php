<?php

/**
 * ----------ASTATINE-KERNELFILE----------
 * - This file contains the env loader
 * - for run the application.
 */

use Dotenv\Dotenv;

require 'vendor/autoload.php';

$env = Dotenv::createImmutable(__DIR__);
$env->load();
