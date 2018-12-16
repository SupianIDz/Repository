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

namespace Octopy\Engine\Compiler;

use Octopy\Engine;
use Octopy\Engine\Stream;

class PHPDirective
{
    /**
     *
     */
    public function __construct()
    {
    }

    /**
     * @param  Stream $stream
     * @param  Engine $engine
     * @return string
     */
    public function parse(Stream $stream, Engine $engine)
    {
        if ($stream->next('php')) {
            return $stream->args();
        }
    }
}
