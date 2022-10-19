<?php

namespace App\Facades;

use App\Providers\MaskProvider;

/*********************************************************
 * -----------------MASK FACADE----------------- 
 *
 * The Mask Facade provides encryptation for the sensible
 * data in your application.
 * 
 *********************************************************/
class Mask extends MaskProvider
{
    /**
     * @param string $unencriptedString
     * @param int $rounds
     * @return string
     * 
     * The make method generate an hash using the string passed by
     * param by the rounds number specified.
     * 
     * Warning: Run the crypto test for check the ideal rounds number
     * for your enviroment. A large number of rounds can negatively
     *  affect your server's performance.
     */
    public static function make(string $stringToEncrypt, int $rounds = 10): string
    {
        return parent::makeHash($stringToEncrypt, $rounds);
    }

    /**
     * @param string $unencriptedString
     * @param string $encryptedString
     * @return bool
     * 
     * The check method verify if the target string's hash matches with the
     * hashed string on second param.
     */
    public static function check(string $unencriptedString, string $encryptedString): bool
    {
        return parent::checkHash($unencriptedString, $encryptedString);
    }
}