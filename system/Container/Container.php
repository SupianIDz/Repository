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

use Closure;
use ReflectionClass;
use RunTimeException;

class Container
{
    /**
     * @var array
     */
    public static $instance = [];

    /**
     * @param string $abstract
     * @param mixed  $concrete
     */
    public static function set(string $abstract, $concrete = null)
    {
        if (is_null($concrete)) {
            $concrete = $abstract;
        }

        Container::$instance[$abstract] = $concrete;
    }

    /**
     * @param  string $abstract
     * @return bool
     */
    public static function isset(string $abstract) : bool
    {
        return isset(Container::$instance[$abstract]);
    }

    /**
     * @param  string $abstract
     * @return void
     */
    public static function unset(string $abstract)
    {
        if (Container::isset($abstract)) {
            unset(Container::$instance[$abstract]);
        }
    }

    /**
     * @param  string $abstract
     * @param  array  $parameter
     * @return object
     */
    public static function make(string $abstract, array $parameter = [])
    {
        if (!Container::isset($abstract)) {
            Container::set($abstract);
        }

        return Container::resolve(Container::$instance[$abstract], $parameter);
    }

    /**
     * @param  abstract $concrete
     * @param  array    $parameters
     * @return mixed
     * @throws RunTimeException
     */
    public static function resolve($concrete, array $parameter = [])
    {
        if ($concrete instanceof Closure) {
            return $concrete(new Container, $parameter);
        }

        $reflector = new ReflectionClass($concrete);

        if (!$reflector->isInstantiable()) {
            throw new RunTimeException;
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return $reflector->newInstance();
        }

        return $reflector->newInstanceArgs($parameter);
    }
}
