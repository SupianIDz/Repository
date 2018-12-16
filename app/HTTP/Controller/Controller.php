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

namespace App\HTTP;

use Octopy\Validation\ValidationRequest;
use Octopy\HTTP\Controller as BaseController;

class Controller extends BaseController
{
    use ValidationRequest;

    /**
     * Costum Class Loader
     * @var array
     */
    protected $autoload = [
    	'request'  => \Octopy\Support\Request::class,
    	'response' => \Octopy\Support\Response::class,
    ];
}
