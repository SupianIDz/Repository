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

namespace Octopy\Database;

use Octopy\Container;

abstract class Seeder
{
    /**
     * @var array
     */
    public $call = [];

    /**
     * @param  array|string $seeder
     * @return void
     */
    public function call($seeder)
    {
        $this->call = array_merge($this->call, is_array($seeder) ? $seeder : [$seeder]);
    }
}
