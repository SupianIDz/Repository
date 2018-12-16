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

final class FUpload
{
    /**
     * @var array
     */
    private $file;
    
    /**
     * @param array $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function name() : string
    {
        return $this->file['name'];
    }

    /**
     * @return string
     */
    public function type() : string
    {
        return $this->file['type'];
    }

    /**
     * @return string
     */
    public function tmp() : string
    {
        return $this->file['tmp_name'];
    }

    /**
     * @return string
     */
    public function size() : string
    {
        return $this->file['size'];
    }

    /**
     * @return string
     */
    public function error() : int
    {
        return $this->file['error'];
    }

    /**
     * @param  string $dest
     * @return bool
     */
    public function move(string $dest)
    {
        if ($status = copy($this->tmp(), $dest)) {
            unlink($this->tmp());
        }

        return $status;
    }
}
