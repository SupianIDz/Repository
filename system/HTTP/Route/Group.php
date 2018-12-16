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

namespace Octopy\HTTP\Route;

use Closure;

class Group
{
    /**
     * @var array
     */
    private static $prefix = [];

    /**
     * @var array
     */
    private static $nspace = [];

    /**
     * @param  array $new
     * @return new Group
     */
    public static function update(array $option, Closure $closure)
    {
        if (isset($option['prefix'])) {
            array_push(Group::$prefix, $option['prefix']);
        }

        if (isset($option['namespace'])) {
            array_push(Group::$nspace, $option['namespace']);
        }

        if ($closure instanceof Closure) {
            call_user_func($closure);
        }

        return Group::revert($option);
    }

    /**
     * @param  array $option
     * @return void
     */
    public static function revert(array $option)
    {
        if (isset($option['prefix'])) {
            array_pop(Group::$prefix);
        }

        if (isset($option['namespace'])) {
            array_pop(Group::$nspace);
        }

        return new Group;
    }

    /**
     * @param  string $uri
     * @return string
     */
    public static function prefix(string $uri) : string
    {
        return DS . Group::trim(implode(DS, Group::$prefix) . DS . $uri);
    }

    /**
     * @param  string $act
     * @return string
     */
    public static function nspace($act)
    {
        if ($act instanceof Closure) {
            return $act;
        }

        return Group::trim(BS . implode(BS, Group::$nspace) . BS . $act);
    }

    /**
     * @param  mixed $data
     * @return mixed
     */
    private static function trim($data)
    {
        if (!is_string($data)) {
            return $data;
        }

        $pattern = [
            DS => '/\/{2,}/',
            BS => '/\\\\{2,}/'
        ];

        return preg_replace($pattern, array_keys($pattern), trim(trim($data, DS), BS));
    }
}
