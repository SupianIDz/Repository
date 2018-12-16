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

namespace Octopy\HTTP\URL;

use Octopy\HTTP\URL;
use Octopy\Container;
use Octopy\Support\Session;
use Octopy\Support\Response;

class Redirect
{
    /**
     * @param string $url
     */
    public function url(string $url = '')
    {
        if (preg_match('#^http(s)?://#', $url)) {
            $this->redirect($url);
        }

        $this->redirect($url);
    }

    /**
     * @param string $url
     */
    public function to(string $url)
    {
        $this->url($url);
    }

    /**
     * @param string $name
     * @param array  $args
     */
    public function route(string $name, array $args = [])
    {
        $this->redirect(Container::make(URL::class)->route($name, $args), $code);
    }

    /**
     * @return void
     */
    public function back()
    {
        $this->redirect(Container::make(URL::class)->previous());
    }

    /**
     * @param  array    $data
     * @return Redirect
     */
    public function session(array $data)
    {
        Session::set($data);
        return $this;
    }

    /**
     * @param  array    $data
     * @return Redirect
     */
    public function flash(array $data)
    {
        Session::flash($data);
        return $this;
    }

    /**
     * @param string $location
     */
    protected function redirect(string $location)
    {
        header('location: ' . $location);
        exit(0);
    }
}
