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
use Reflector;
use ReflectionMethod;
use ReflectionFunction;

use Octopy\Container;
use Octopy\HTTP\Request;

final class Dispatcher
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var callable
     */
    private $action;

    /**
     * @var array
     */
    private $params;

    /**
     * @param array $route
     */
    public function __construct($route)
    {
        $this->action = $route['action'];
        $this->params = $route['params'] ?? [];
    }

    /**
     * @param  Request $request
     * @return string
     */
    public function dispatch(Request $request)
    {
        $fallback = $this->fallback();

        if ($fallback instanceof Closure) {
            $reflector = new ReflectionFunction($fallback);

            return $reflector->invoke(...$this->parameter($reflector, $request));
        }

        extract($fallback);

        $reflector = new ReflectionMethod($class, $method);

        return $reflector->invoke(Container::make($class), ...$this->parameter($reflector, $request));
    }

    /**
     * @param  Reflector $reflector
     * @param  Request   $request
     * @return array
     */
    private function parameter(Reflector $reflector, Request $request) : array
    {
        $parameter = array_merge([$request], $this->params);
        foreach ($reflector->getParameters() as $offset => $param) {
            $type = explode(BS, (string)$param->getType());
            if ($offset === 0 && end($type) !== 'Request') {
                unset($parameter[0]);
                break;
            }
        }

        return $parameter;
    }

    /**
     * @return Closure|array
     */
    private function fallback()
    {
        if ($this->action instanceof Closure) {
            return $this->action;
        }

        list($class, $method) = explode('@', $this->action);
        return [
            'class'  => $class,
            'method' => $method
        ];
    }
}
