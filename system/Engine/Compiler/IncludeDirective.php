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

class IncludeDirective
{
    /**
     * @var array
     */
    const PATTERN = '/\((.*)\)/';

    /**
     * @var array
     */
    protected $token;
    
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
        $file = preg_replace(IncludeDirective::PATTERN, '$1', $stream->args());
        if ($stream->token() === T_INCLUDE) {
            return sprintf('$this->include(%s)', $file);
        }

        if ($stream->token() === T_REQUIRE) {
            return sprintf('$this->require(%s)', $file);
        }
    }
}
