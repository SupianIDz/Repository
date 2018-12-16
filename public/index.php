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

define('OCTOPY_START_TIME', microtime(true));

$app = require '../system/Octopy.php';

$kernel = $app->make(App\HTTP\Kernel::class);

$response = $kernel->handle(
    $request = $app->make(Octopy\HTTP\Request::class)
);

$kernel->terminate($response, $request);
