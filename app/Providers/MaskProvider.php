<?php

namespace App\Providers;

/*********************************************************
 * -----------------MASK PROVIDER-----------------
 * 
 * The Mask Facade provides encryptation for the sensible
 * data in your application.
 *********************************************************/
class MaskProvider
{
    //TODO: Add the models that has fields to be hasheds.
    protected array $register = [

    ];

    private static function getCryptOptions($configs, $rounds)
    {
        try
        {
            
            $options = [
                'cost' => $rounds,
                'memory_cost' => $configs['CRYPTO_MEMORY_COST'],
                'time_cost' => $configs['CRYPTO_TIME_COST'],
                'theads' => $configs['CRYPTO_THREADS']
            ];
            
            return $options;
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

    protected static function makeHash(string $stringToEncrypt, int $rounds): string
    {
        try
        {
            $configs = include 'config/crypto.php';
            $options = self::getCryptOptions($configs, $rounds);
            $crypto = password_hash($stringToEncrypt, $configs['CRYPTO_ALGO'], $options);

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
