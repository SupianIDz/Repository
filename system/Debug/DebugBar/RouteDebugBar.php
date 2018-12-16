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

namespace Octopy\Debug\DebugBar;

use Exception;

use Octopy\Support\Route;

class RouteDebugBar
{
    /**
    *
    */
    public function __construct()
    {
        Route::group(['prefix' => '__octopy_debugbar', 'namespace' => 'Octopy\Debug\DebugBar'], function () {
            Route::prefix('__asset', function () {
                Route::get('js/:file', 'DebugBarController@js')->name('debugbar.js');
                Route::get('css/:file', 'DebugBarController@css')->name('debugbar.css');
                Route::get('font/:file', 'DebugBarController@font')->name('debugbar.font');
            });

            Route::prefix('__action', function () {
                Route::post('load', 'DebugBarController@load')->name('debugbar');
                Route::post('reload', 'DebugBarController@load')->name('debugbar.reload');
                Route::post('delete', 'DebugBarController@delete')->name('debugbar.delete');
            });
        });
    }
}
