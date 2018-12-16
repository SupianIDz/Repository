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

namespace Octopy\Engine;

final class Stream
{
    /**
     * @var [type]
     */
    private $line;

    /**
     * @param array $line
     */
    public function __construct(array $line)
    {
        $this->line = $line;
    }

    /**
     * @return string
     */
    public function code() : string
    {
        $source = explode('(', $this->line['value']);
        return $source[0];
    }

    /**
     * @return string|bool
     */
    public function args() : ?string
    {
        if (preg_match('^\((.*)\)^', $this->line['value'], $match)) {
            return $match[0];
        }

        return false;
    }

    /**
     * @return int
     */
    public function token() : int
    {
        return $this->line['token'];
    }

    /**
     * @return string
     */
    public function raw()
    {
        return $this->line['value'];
    }

    /**
     * @param  int|string
     * @return bool
     */
    public function next($next) : bool
    {
        if ($next == $this->line['token'] || $next == $this->code()) {
            return true;
        }

        return false;
    }
}
