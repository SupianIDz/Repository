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

class ControlDirective
{
    /**
     *
     */
    public function __construct()
    {
        $this->open  = [T_FOR, T_FOREACH, T_IF, T_ELSEIF, T_ELSE, T_WHILE];
        $this->close = [T_ENDFOR, T_ENDFOREACH, T_ENDIF, T_ENDWHILE];
    }

    /**
     * @param  Stream $stream
     * @param  Engine $engine
     * @return string
     */
    public function parse(Stream $stream, Engine $engine)
    {
        foreach ($this->open as $token) {
            if ($stream->next($token)) {
                return $stream->raw() . ':';
            }
        }

        if (in_array($stream->token(), $this->close)) {
            return $stream->code();
        }
    }
}
