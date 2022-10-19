<?php

/*********************************************************
 * -----------------CRYPTO CONFIGS FILE----------------- 
 *
 * This file returns the config to be used on Mask facade.
 * 
 *********************************************************/
return [

    'CRYPTO_ALGO' => PASSWORD_BCRYPT,

    'CRYPTO_MEMORY_COST' => PASSWORD_BCRYPT_DEFAULT_COST,
    
    'CRYPTO_TIME_COST' => null,

    'CRYPTO_THREADS' => null
];

