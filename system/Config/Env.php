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

namespace Octopy\Config;

class Env
{
    /**
     *
     */
    public function __construct()
    {
        if (file_exists(($dotenv = $dotenv = BASEPATH . '.env'))) {
            $envs = explode("\n", file_get_contents($dotenv));
            foreach ($envs as $env) {
                $env = explode('=', $env);
                if (isset($env[0]) && isset($env[1])) {
                    $this->set(...$env);
                }
            }
        }
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function set(string $key, $value = null)
    {
        $value = trim($value);
                   
        if (strtolower($value) == 'true') {
            $value = true;
        } elseif (strtolower($value) == 'false') {
            $value = false;
        } elseif (strtolower($value) == 'null') {
            $value = null;
        }

        putenv($key . '=' . $value);
        $_ENV[$key] = $value;
    }

    /**
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }

    /**
     * @return array
     */
    public function all() : array
    {
        return $_ENV;
    }
}
