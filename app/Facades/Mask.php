<?php

namespace App\Facades;

use App\Providers\MaskProvider;

class Mask extends MaskProvider
{
    public static function make(string $unencriptedString, int $rounds = 8)
    {
        return parent::makeHash($unencriptedString, $rounds);
    }

    public static function check(string $unencriptedString, string $encryptedString)
    {
        return parent::checkHash($unencriptedString, $encryptedString);
    }
}