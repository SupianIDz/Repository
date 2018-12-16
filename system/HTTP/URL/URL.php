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

use Octopy\Support\Route;
use Octopy\Support\Request;

class URL
{
    /**
     * @param  string $name
     * @param  array  $parameter
     * @return string
     */
    public function route(string $name, array $parameter = [])
    {
        $fragment = [];
        foreach (Route::data() as $route) {
            if ($name === $route['name']) {
                $url = $route['target'];
                if (preg_match_all('/(?<=\/):([^\/]+)(?=\/|$)/', $url, $match)) {
                    $fragment = [];
                    foreach ($match[1] as $key) {
                        if (isset($parameter[$key])) {
                            $fragment[':' . $key] = $parameter[$key];
                        }
                    }

                    if (count($fragment) < count($match[1])) {
                        throw new URL\Exception\MissingRouteParameterException;
                    }
                }

                break;
            }
        }

        if (!isset($url)) {
            throw new URL\Exception\RouteNotExistException;
        }

        return str_replace(' ', '%20', str_replace(array_flip($fragment), $fragment, $url));
    }

    /**
     * @return string
     */
    public function previous() : string
    {
        return Request::referer();
    }
}
