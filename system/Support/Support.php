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

use RuntimeException;

use Octopy\Container;

abstract class Support
{
    /**
     * @var array
     */
    protected static $resolve = [];
    
    /**
     * @param  string $method
     * @param  array  $args
     * @return object
     */
    public static function __callStatic(string $method, array $args = [])
    {
        return Support::resolve(static::accessor(), $method, $args);
    }

    /**
     * @param  string $method
     * @param  array  $args
     * @return object
     */
    public function __call(string $method, array $args = [])
    {
        return Support::resolve(static::accessor(), $method, $args);
    }

    /**
     * @param  stirng $accessor
     * @param  string $method
     * @param  array  $args
     * @return object
     */
    private static function resolve(string $accessor, string $method, array $args = [])
    {
        if (!array_key_exists($accessor, Support::$resolve)) {
            Support::$resolve[$accessor] = Container::make($accessor);
        }

        return Support::$resolve[$accessor]->$method(...$args);
    }
}
