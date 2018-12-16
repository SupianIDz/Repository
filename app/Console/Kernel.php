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

namespace App\Console;

use Octopy\Support\Console;
use Octopy\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * @return void
     */
    public function boot()
    {
        Console::register('Console.php');
    }
}
