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

namespace Octopy;

class Session
{
    /**
     *
     */
    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * @param  string|array $key
     * @param  mixed        $value
     * @param  bool         $replace
     * @return Session
     */
    public function set($key, $value = null, bool $replace = true) : Session
    {
        if (is_array($key) && $value === null) {
            foreach ($key as $key => $value) {
                $this->set($key, $value);
            }

            return $this;
        }

        if ($replace) {
            $_SESSION[$key] = $value;
        } else {
            $_SESSION[$key] = $_SESSION[$key] ?? $value;
        }

        return $this;
    }

    /**
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * @param  string $key
     * @return mixed
     */
    public function flash($key)
    {
        if (is_array($key)) {
            return $this->set($key);
        }

        if (isset($_SESSION[$key])) {
            $flash = $_SESSION[$key];
            $this->forget($flash);
        }

        return $flash ?? [];
    }

    /**
     * @param  string $key
     * @return Session
     */
    public function forget(string $key) : Session
    {
        if ($this->isset($key)) {
            unset($_SESSION[$key]);
        }

        return $this;
    }

    /**
     * @return Session
     */
    public function flush() : Session
    {
        foreach ($this->all() as $key =>$value) {
            $this->forget($key);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function all() : array
    {
        $session = [];
        foreach ($_SESSION as $key => $value) {
            if ($key === 'OCTOPY_DEBUGBAR') {
                continue;
            }

            $session[$key] = $value;
        }

        return $session;
    }

    /**
     * @param  string $key
     * @return bool
     */
    public function isset(string $key) : bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * @return Session
     */
    public function instance() : Session
    {
        return $this;
    }
}
