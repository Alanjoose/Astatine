<?php

namespace App\Providers;

class MaskProvider
{
    protected static function generateHash($string, $rounds)
    {
        try
        {
            $configs = include 'config/crypto.php';
            if(is_null($rounds)) {
                $rounds = $configs['CRYPTO_DEFAULT_COST'];
            }

            $encrypted = password_hash($string, $configs['CRYPTO_ALGORITHM'], [
                'cost' => $rounds
            ]);
            return $encrypted;
        }
        catch(\Exception $exception)
        {
            return [
                'message' => 'Error on hash generate',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    protected static function checkHash($string, $hash)
    {
        try
        {
            $match = password_verify($string, $hash);
            return $match;
        }
        catch(\Exception $exception)
        {
            return [
                'message' => 'Error on check the string hash',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    protected static function checkIfNeedsRehash($string, $hash)
    {
        try
        {
            $configs = include 'config/crypto.php';
            if(!self::checkHash($string, $hash)) {
                throw new \Exception("The hash value doesn't matches with string");
            }

            return password_needs_rehash($hash, $configs['CRYPTO_ALGORITHM'], [
                'cost' => $configs['CRYPTO_DEFAULT_COST']
            ]);
        }
        catch(\Exception $exception)
        {
            return [
                'message' => 'Error on check if the encrypted string needs rehash',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    protected static function getCryptoInfo($hash)
    {
        try
        {
            return password_get_info($hash);
        }
        catch(\Exception $exception)
        {
            return [
                'message' => 'Error on check the hash info',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }
}
