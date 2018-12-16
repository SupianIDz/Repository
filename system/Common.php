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


if (!function_exists('basepath')) {
    /**
     * @param  string|null $path
     * @param  string|null $file
     * @return string
     */
    function basepath(string $path = null, string $file = null) : string
    {
        return BASEPATH . preg_replace('/\./', DS, trim($path, '.')) . DS . $file;
    }
}

if (!function_exists('app')) {
    /**
     * @param  string|null $path
     * @param  string|null $file
     * @return string
     */
    function app(string $path = null, string $file = null) : string
    {
        return basepath('app.' . $path, $file);
    }
}

if (!function_exists('storage')) {
    /**
     * @param  string|null $path
     * @param  string|null $file
     * @return string
     */
    function storage(string $path = null, string $file = null) : string
    {
        return basepath('storage.' . $path, $file);
    }
}

if (!function_exists('octopy')) {
    /**
     * @param  string|null $path
     * @param  string|null $file
     * @return string
     */
    function octopy(string $path = null, string $file = null) : string
    {
        return basepath('system.' . $path, $file);
    }
}

if (!function_exists('csrf')) {
    /**
     * @param  bool $form
     * @return string
     */
    function csrf(bool $form = false) : string
    {
        $token = Octopy\HTTP\Middleware\CSRF::generate();
        if ($form) {
            return '<input type="hidden" name="OCTOPY_CSRF" value="' . $token . '">' . PHP_EOL;
        }

        return $token;
    }
}

if (!function_exists('view')) {
    /**
     * @param  string $template
     * @param  array  $data
     * @param  bool   $static
     * @param  bool   $minify
     * @return string
     */
    function view(string $template, array $data = [], bool $static = null, bool $minify = false) : string
    {
        return Octopy\Support\View::render($template, $data, $static, $minify);
    }
}

if (!function_exists('config')) {
    /**
     * @param  string $key
     * @param  bool   $object
     * @return mixed
     */
    function config(string $key, bool $object = true)
    {
        return Octopy\Support\Config::get($key, $object);
    }
}

if (!function_exists('route')) {
    /**
     * @param  string $name
     * @param  array  $parameter
     * @return string
     */
    function route(string $name, array $parameter = [])
    {
        return Octopy\Support\URL::route($name, $parameter);
    }
}

if (!function_exists('env')) {
    /**
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    function env(string $key, $default = null)
    {
        return Octopy\Support\Env::get($key, $default);
    }
}

if (!function_exists('response')) {
    /**
     * @return Response
     */
    function response()
    {
        return new Octopy\Support\Response;
    }
}

if (!function_exists('redirect')) {
    /**
     * @return Redirect
     */
    function redirect()
    {
        return new Octopy\HTTP\URL\Redirect;
    }
}

if (!function_exists('url')) {
    /**
     * @param  string|null $url
     * @return string
     */
    function url(string $url = null)
    {
        return config('app.url') . $url;
    }
}
