<?php

/*********************************************************
 * -----------------DB CONFIGS FILE----------------- 
 *
 * This file returns the configs to be used on DBProvider
 * module.
 * 
 *********************************************************/
return [

    'DATABASE_DRIVER' => $_ENV['DATABASE_DRIVER'],

    'DATABASE_HOST' => $_ENV['DATABASE_HOST'],

    'DATABASE_PORT' => $_ENV['DATABASE_PORT'],

    'DATABASE_NAME' => $_ENV['DATABASE_NAME'],

    'DATABASE_USERNAME' => $_ENV['DATABASE_USERNAME'],

    'DATABASE_PASSWORD' => $_ENV['DATABASE_PASSWORD']

];