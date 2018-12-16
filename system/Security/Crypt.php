<?php

/**
 *   ___       _
 *  / _ \  ___| |_ ___  _ __  _   _
 * | | | |/ __| __/ _ \| '_ \| | | |
 * | |_| | (__| || (_) | |_) | |_| |
 *  \___/ \___|\__\___/| .__/ \__, |
 *                     |_|    |___/
 * @author  : Supian M <supianidz@gmail.com>
 * @version : v1.0
 * @license : MIT
 */

namespace Octopy\Security;

use Octopy\Security\Exception\EncryptionKeyException;

class Crypt
{
    /**
     *
     */
    public function __construct()
    {
        $this->config = config('security');
        if (!$this->config->key) {
            throw new EncryptionKeyException;
        }
    }

    /**
     * @param  string $string
     * @return string
     */
    public function encrypt(string $string) : string
    {
        return base64_encode(
            openssl_encrypt($string, $this->config->cipher, $this->config->key, OPENSSL_RAW_DATA, $this->iv())
        );
    }

    /**
     * @param  string $encrypted
     * @return string
     */
    public function decrypt(string $encrypted) : string
    {
        return openssl_decrypt(base64_decode($encrypted), $this->config->cipher, $this->config->key, OPENSSL_RAW_DATA, $this->iv());
    }

    /**
     * @return char
     */
    private function iv()
    {
        $iv  = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        $iv .= chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        $iv .= chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        $iv .= chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        return $iv;
    }
}
