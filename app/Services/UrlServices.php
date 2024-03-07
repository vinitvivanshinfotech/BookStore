<?php

namespace App\Services;

use Crypt;

/**
 * Methods for safe manipulation of urls
 */
class UrlService
{

    /**
     * [base64UrlEncode Convert input into base64 encoded encypted string]
     *
     * @param  string $input
     * @return void
     */
    public static function base64UrlEncode($input)
    {
        return strtr(base64_encode(Crypt::encrypt($input)), '+/=', '._-'); // "+", "/" and "=" are not url safe
    }

    /**
     * [base64UrlDecode Decode base64 encoded encypted string]
     *
     * @param  string $input
     * @return void
     */
    public static function base64UrlDecode($input)
    {
        return Crypt::decrypt(base64_decode(strtr($input, '._-', '+/=')));
    }
}