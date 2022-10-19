<?php

namespace App\Providers;

/*********************************************************
 * -----------------MASK PROVIDER-----------------
 * 
 * The Mask Facade provides encryptation for the sensible
 * data in your application.
 * 
 * @var protected array $register[]
 * @method static getCryptOptions($configs, $rounds)
 *********************************************************/
class MaskProvider
{
    //TODO: Add the models that has fields to be hasheds.
    protected array $register = [

    ];

    protected static function makeHash(string $stringToEncrypt, int $rounds): string
    {
        try
        {
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
                'message' => 'Error on hash generate.',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

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
