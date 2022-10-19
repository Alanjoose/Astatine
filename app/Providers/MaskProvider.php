<?php

namespace App\Providers;

/***********************************************************************************
 * -----------------MASK PROVIDER-----------------
 * 
 * The Mask Facade provides the encryptation logic
 *  for the sensible data in your application.
 * 
 * @var protected array $register[]
 * @method static makeHash(string $stringToEncrypt, int $rounds): string
 * @method static checkHash(string $unencryptedString, string $encryptedString): bool
*************************************************************************************/
class MaskProvider
{
    /**
     * Recieves the models with sensible data to be encrypt
     * before goes to database.
     */
    protected array $register = [
        //TODO: Add the models that has fields to be hasheds.
    ];

    /**
     * Hash generation logic goes here.
     * 
     * @param string $stringToEncrypt
     * @param int $rounds
     * @return string
     */
    protected static function makeHash(string $stringToEncrypt, int $rounds): string
    {
        try
        {
            #Loads the crypo configs file.
            $configs = include 'config/crypto.php';

            $crypto = password_hash($stringToEncrypt, $configs['CRYPTO_ALGO'], [
                'cost' => $rounds,
                'memory_cost' => $configs['CRYPTO_MEMORY_COST'],
                'time_cost' => $configs['CRYPTO_TIME_COST'],
                'threads' => $configs['CRYPTO_THREADS']
            ]);

            return $crypto;
        }
        catch(\Exception $exception)
        {
            return [
                'message' => 'Error on generate hash.',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    /**
     * Hash verify logic goes here.
     * 
     * @param string $unencryptedString
     * @param string $encryptedString
     * @return bool
     */
    protected static function checkHash(string $unencryptedString, string $encrypedString): bool
    {
        try
        {
            $match = password_verify($unencryptedString, $encrypedString);

            return $match;
        }
        catch(\Exception $exception)
        {
            return [
                'message' => 'Error on hash generate.',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }
}
