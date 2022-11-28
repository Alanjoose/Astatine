<?php

namespace App\Facades;

use App\Providers\MaskProvider;

class Mask extends MaskProvider
{
    public static function hide($string, $rounds = null)
    {
        return parent::generateHash($string, $rounds);
    }

    public static function matches($string, $hash)
    {
        return parent::checkHash($string, $hash);
    }

    public static function needsRehash($string, $hash)
    {
        return parent::checkIfNeedsRehash($string, $hash);
    }

    public static function getHashInfo($hash)
    {
        return parent::getCryptoInfo($hash);
    }
}
