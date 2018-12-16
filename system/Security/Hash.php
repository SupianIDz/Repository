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

class Hash
{
    /**
     * @var int
     */
    const DEFAULT = PASSWORD_DEFAULT;

    /**
     * @var int
     */
    const BCRYPT = PASSWORD_BCRYPT;

    /**
     *
     */
    private $config;

    /**
     *
     */
    public function __construct()
    {
        $this->bcrypt = config('security.bcrypt');
    }


    /**
     * @param  string $string
     * @param  int    $algoritma
     * @return string
     */
    public function make(string $string, int $algoritma = null) : string
    {
        $algoritma = $algoritma ?? Hash::DEFAULT;
        return password_hash($string, $algoritma, [
            'cost' => $this->bcrypt->cost
        ]);
    }

    /**
     * @param  string $string
     * @param  string $hash
     * @return bool
     */
    public function verify(string $string, string $hash) : bool
    {
        return password_verify($string, $hash);
    }
}
