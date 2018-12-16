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

use Octopy\Support\Route;
use Octopy\HTTP\Kernel as HTTPKernel;

class Kernel extends HTTPKernel
{
    /**
     * @var string
     */
    protected $namespace = 'App\HTTP\Controller';

    /**
     * @var array
     */
    protected $middleware = [
        Middleware\CSRFVerifyToken::class
    ];

    /**
     * @var array
     */
    protected $routemiddleware = [];

    /**
     * @return void
     */
    protected function boot()
    {
        Route::namespace($this->namespace, function () {
            Route::register('Web.php');

            Route::prefix('api', function () {
                Route::register('Api.php');
            });
        });
    }
}
