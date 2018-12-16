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

namespace App\Exception;

use Throwable;

use Octopy\HTTP\Request;
use Octopy\Debug\Handler as ExceptionHandler;
use Octopy\HTTP\Route\Exception\RouteNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * @param  Request   $request
     * @param  Throwable $exception
     * @return string
     */
    public function render(Request $request, Throwable $exception)
    {
    	if($exception instanceof RouteNotFoundException && !$request->ajax()) {
    		return redirect()->to('/');
    	}

        return parent::render($request, $exception);
    }
}
