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

/**
 *
 */
require 'Constant.php';

/**
 *
 */
require 'Common.php';

/**
 *
 */
require 'AutoLoader.php';

/**
 * @var AutoLoader
 */
$autoload = new Octopy\AutoLoader;
$autoload->class(function () : array {
    return require app('Config', 'App.php');
});

/**
 * @var Composer
 */
if (file_exists($composer = BASEPATH . 'vendor/autoload.php')) {
    require $composer;
}

/**
 * @var Application
 */
return new Octopy\Application;
