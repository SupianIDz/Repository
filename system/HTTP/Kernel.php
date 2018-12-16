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

use Octopy\Container;
use Octopy\HTTP\Request;
use Octopy\Support\Route;
use Octopy\HTTP\Response;
use Octopy\Support\DebugBar;
use Octopy\HTTP\Route\Dispatcher;
use Octopy\HTTP\Route\Exception\RouteNotFoundException;
use Octopy\HTTP\Route\Exception\MethodNotAllowedException;

class Kernel
{
    /**
     *
     */
    public function __construct()
    {
        $this->boot();
    }

    /**
     * @param  Request $request
     * @return string
     */
    public function handle(Request $request)
    {
        $route = Route::instance();

        if ($match = $route->match($request->uri())) {
            if (!in_array($request->method(), $match['method'])) {
                throw new MethodNotAllowedException;
            }

            foreach ($match['middleware'] as $middleware) {
                if (is_string($middleware) && isset($this->routemiddleware[$middleware])) {
                    $middleware = $this->routemiddleware[$middleware];
                }

                $this->middleware[] = $middleware;
            }

            foreach ($this->middleware as $middleware) {
                if ($middleware instanceof Closure) {
                    $request = $middleware($request);
                } else {
                    $request = Container::resolve($middleware)->handle($request);
                }

                if (!$request instanceof Request) {
                    return $this->response($request);
                }
            }

            $dispatch = Container::make(Dispatcher::class, [$match])->dispatch($request);

            return $this->response($dispatch);
        }

        throw new RouteNotFoundException;
    }

    /**
     * @param  Response $response
     * @return Response
     */
    private function response($response) : Response
    {
        if (!$response instanceof Response) {
            return new Response($response);
        }

        return $response;
    }

    /**
     * @param  Response $response
     * @param  Request  $request
     */
    public function terminate(Response $response, Request $request)
    {
        if (config('app.debug')) {
            if (!preg_match('/__octopy_debugbar/', $request->uri())) {
                $data = [
                    'elapsed' => microtime(true) - OCTOPY_START_TIME,
                    'memory'  => memory_get_usage()
                ];
                $response .= DebugBar::collect($data)->inject();
            }
        }

        echo $response;
        unset($response, $request);
        exit(0);
    }
}
