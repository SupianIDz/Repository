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

namespace Octopy\HTTP;

use Closure;
use ArrayIterator;
use IteratorAggregate;

use Octopy\HTTP\Request;
use Octopy\HTTP\Route\Group;

class Route implements IteratorAggregate
{
    /**
     * @var array
     */
    private $routes = [];

    /**
     * @var new Group
     */
    private $group;
    
    /**
     * @var array
     */
    private $matched;

    /**
     * @param  array   $option
     * @param  Closure $closure
     */
    public function group(array $option, Closure $closure)
    {
        Group::update($option, $closure);
        return $this;
    }

    /**
     * @param  string   $uri
     * @param  callable $act
     * @return Route
     */
    public function get(string $uri, $act)
    {
        return $this->set(['GET'], $uri, $act);
    }

    /**
     * @param  string   $uri
     * @param  callable $act
     * @return Route
     */
    public function post(string $uri, $act)
    {
        return $this->set(['POST'], $uri, $act);
    }

    /**
     * @param  string   $uri
     * @param  callable $act
     * @return Route
     */
    public function any(string $uri, $act)
    {
        return $this->set(['GET', 'POST'], $uri, $act);
    }

    /**
     * @param string $name
     */
    public function name(string $name)
    {
        $i = count($this->routes) - 1;
        $this->routes[$i]['name'] = $name;
        return $this;
    }

    /**
     * @param  mixed $middleware
     * @return Route
     */
    public function middleware($middleware)
    {
        $i = count($this->routes) - 1;
        $this->routes[$i]['middleware'] = !is_array($middleware) ? [$middleware] : $middleware;
        return $this;
    }
    
    /**
     * @param  string    $prefix
     * @param  Closure   $callback
     * @return Route
     */
    public function prefix(string $prefix, Closure $callback)
    {
        return $this->group(['prefix' => $prefix], $callback);
    }

    /**
     * @param  string    $namespace
     * @param  Closure   $callback
     * @return Route
     */
    public function namespace(string $namespace, Closure $callback)
    {
        return $this->group(['namespace' => $namespace], $callback);
    }

    /**
     * @param  string $route
     * @return Route
     */
    public function register(string $route)
    {
        if (file_exists($route = app('Route', $route))) {
            require $route;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function data() : array
    {
        return $this->routes;
    }

    /**
     * @param array    $method
     * @param string   $uri
     * @param callable $act
     */
    private function set($method, string $uri, $act)
    {
        array_push($this->routes, [
            'name'       => '',
            'target'     => Group::prefix($uri),
            'method'     => $method,
            'middleware' => [],
            'action'     => Group::nspace($act),
        ]);

        return $this;
    }

    /**
     * @return Route
     */
    public function instance()
    {
        return $this;
    }

    /**
     * @return bool
     */
    public function match(string $uri)
    {
        foreach ($this->routes as $route) {
            if ($uri === $route['target']) {
                $this->matched = array_merge($route, [
                    'params' => []
                ]);
                break;
            } else {
                preg_match_all('/(?<=\/):([^\/]+)(?=\/|$)/', $route['target'], $matches);

                if (!empty($matches)) {
                    $dirty = $regex = [];

                    foreach ($matches[0] as $i => $match) {
                        $dirty[] = '/' . $match . '/';
                        $regex[] = substr($matches[1][$i], -1) === '*' ? '(.+?)' : '([^/]+)';
                    }

                    $pattern = preg_replace('^/^', '\/', preg_replace($dirty, $regex, $route['target']));

                    if (preg_match('/^' . $pattern . '$/', $uri, $parameter)) {
                        array_shift($parameter);
                        $this->matched = array_merge($route, [
                            'params' => $parameter
                        ]);
                        break;
                    }
                }
            }
        }

        return $this->matched;
    }

    /**
     * @return array
     */
    public function debugbar()
    {
        return $this->matched ?? [
            'name'       => '',
            'target'     => '',
            'method'     => [],
            'middleware' => [],
            'action'     => '',
            'params'     => []
        ];
    }

    /**
     * @param  array $route
     * @return bool
     */
    private function construct(array $route)
    {
        foreach ($route as $key => $value) {
            $this->$key = $value;
        }

        return true;
    }

    /**
     * @return new ArrayIterator
     */
    public function getIterator() : ArrayIterator
    {
        return new ArrayIterator($this->routes);
    }
}
