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

namespace Octopy;

use Octopy\Container;

final class Application extends Container
{
    /**
     * @var string
     */
    const VERSION = 'v1.1';

    /**
     *
     */
    public function __construct()
    {
        $this->make(\App\Exception\Handler::class);
        if (config('app.debug')) {
            $this->make(\Octopy\Debug\DebugBar\RouteDebugBar::class);
        }
    }
}
