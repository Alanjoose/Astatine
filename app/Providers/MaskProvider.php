<?php

namespace App\Providers;

class MaskProvider
{
    //TODO: Add the models that has fields to be hasheds.
    protected array $register = [

    ];

    protected static function makeHash(string $unencryptedString, int $rounds): string
    {
        try
        {
            $configs = include 'config/crypto.php';

            $crypto = password_hash($unencryptedString, $configs['CRYPTO_ALGORITHM'], [
                'cost' => $rounds,
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
