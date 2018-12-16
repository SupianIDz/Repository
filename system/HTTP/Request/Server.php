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

namespace Octopy\HTTP\Request;

trait Server
{
    /**
     * @return string
     */
    public function uri() : string
    {
        $root = str_replace(basename($this->server('PHP_SELF')), '', $this->server('PHP_SELF'));
        return str_replace($root, '/', preg_replace('/\/{2,}/', '/', $this->server('REQUEST_URI')));
    }

    /**
     * @return string
     */
    public function method() : string
    {
        return $this->server('REQUEST_METHOD');
    }

    /**
     * @return string
     */
    public function referer() : string
    {
        return $this->server('HTTP_REFERER');
    }

    /**
     * @return string
     */
    public function uagent() : string
    {
        return $this->server('HTTP_USER_AGENT');
    }

    /**
     * @return string
     */
    public function ip() : string
    {
        return $this->server('SERVER_ADDR');
    }

    /**
     * @return bool
     */
    public function cli() : bool
    {
        return PHP_SAPI === 'cli';
    }

    /**
     * @return bool
     */
    public function secure() : bool
    {
        return $this->server('HTTPS') !== null ? true : false;
    }

    /**
     * @return array
     */
    public function headers() : array
    {
        return apache_request_headers();
    }

    /**
     * @return string
     */
    public function protocol() : string
    {
        return $this->server('SERVER_PROTOCOL');
    }

    /**
     * @return bool
     */
    public function ajax() : bool
    {
        if ($this->server('HTTP_X_REQUESTED_WITH')) {
            return strtoupper($this->server('HTTP_X_REQUESTED_WITH')) === 'XMLHTTPREQUEST';
        }

        return false;
    }

    /**
     * @param  string $key
     * @return string
     */
    public function server(string $key = null)
    {
        if ($key === null) {
            return $_SERVER;
        }
        
        return $_SERVER[$key] ?? null;
    }
}
