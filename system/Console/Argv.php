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

namespace Octopy\Console;

class Argv
{
    /**
     *
     */
    public function __construct()
    {
        global $argv;
        $this->argv = $argv;
    }

    /**
     * @return string
     */
    public function command() : string
    {
        return $this->argv[1] ?? '';
    }

    /**
     * @return array
     */
    public function args() : array
    {
        foreach (array_slice($this->argv, 2) as $argv) {
            if (substr($argv, 0, 2) === '--') {
                $piece = explode('=', $argv);
                if (!isset($piece[1])) {
                    list($key) = $piece;
                } else {
                    list($key, $value) = $piece;
                }

                $args[$key] = $value ?? true;
            } elseif (substr($argv, 0, 1) === '-') {
                $args[$argv] = true;
            } else {
                $args['name'] = $argv;
            }
        }
        
        return $args ?? [];
    }

    /**
     * @param  string      $key
     * @return string|bool
     */
    public function get(string $key)
    {
        $args = $this->args();
        
        if (isset($args[$key])) {
            return $args[$key] === '' ? true : $args[$key];
        }
    }
}
