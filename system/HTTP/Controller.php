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

use Octopy\Container;

abstract class Controller
{
    /**
     * @var array
     */
    protected $autoload = [];

    /**
     *
     */
    public function __construct()
    {
        if (!empty($this->autoload)) {
            foreach ($this->autoload as $key => $class) {
                $this->$key = Container::make($class);
            }
        }
    }
}
