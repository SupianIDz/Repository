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

namespace Octopy\HTTP;

use Octopy\Support\Session;
use Octopy\HTTP\Request\Server;
use Octopy\HTTP\Request\FUpload;

class Request
{
    /**
     *
     */
    use Server;

    /**
     *
     */
    public function __construct()
    {
        foreach ($this->all() as $key => $value) {
            $this->$key = $value;
        }
    }
    
    /**
     * @param  string|null $key
     * @param  mixed|null  $default
     * @return mixed
     */
    public function post(string $key = null, $default = null)
    {
        if ($key !== null) {
            return $_POST[$key] ?? $default;
        }

        return $_POST;
    }

    /**
     * @param  string|null $key
     * @param  mixed|null  $default
     * @return mixed
     */
    public function file(string $key = null)
    {
        if (!is_null($key)) {
            return new FUpload($_FILES[$key]);
        }
        
        $files = [];
        foreach ($_FILES as $key => $file) {
            $files[$key] = new FUpload($file);
        }

        return $files;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->post() + $this->file();
    }

    /**
     * @return Session
     */
    public function session()
    {
        return Session::instance();
    }

    /**
     * @return Request
     */
    public function instance() : Request
    {
        return $this;
    }
}
