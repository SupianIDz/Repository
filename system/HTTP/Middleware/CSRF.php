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

namespace Octopy\HTTP\Middleware;

use Octopy\HTTP\Request;
use Octopy\Support\Session;
use Octopy\HTTP\Middleware;
use Octopy\HTTP\Middleware\Exception\TokenMismatchException;

class CSRF extends Middleware
{
    /**
     * @param Request $request
     */
    public function handle(Request $request)
    {
        if (!in_array($request->uri(), $this->except)) {
            if ($this->validate($request) == false) {
                throw new TokenMismatchException;
            }
        }

        unset($request->OCTOPY_CSRF);

        return $request;
    }

    /**
     * @return string
     */
    public static function generate() : string
    {
        if (Session::isset('OCTOPY_CSRF_TOKEN')) {
            $token = Session::get('OCTOPY_CSRF_TOKEN');
        } else {
            $token = md5(random_bytes(32));
        }

        Session::set(array(
            'OCTOPY_CSRF_TOKEN'  => $token,
            'OCTOPY_CSRF_EXPIRE' => time()
        ));

        return $token;
    }

    /**
     * @param  Request $request
     * @return bool
     */
    protected function validate(Request $request) : bool
    {
        if ($request->method() !== 'POST') {
            return true;
        }
        
        $header = apache_request_headers();

        if (isset($header['X-CSRF-TOKEN']) || isset($header['x-csrf-token'])) {
            $token = $header['X-CSRF-TOKEN'] ?? $header['x-csrf-token'];
        } elseif (property_exists($request, 'OCTOPY_CSRF')) {
            $token = $request->OCTOPY_CSRF;
        }

        if (isset($token) && $token === Session::get('OCTOPY_CSRF_TOKEN')) {
            $time = time() - Session::get('OCTOPY_CSRF_EXPIRE');
            return $time < config('security.csrf.lifetime');
        }

        return false;
    }
}
