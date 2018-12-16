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

namespace Octopy\Validation\Rule;

use Octopy\HTTP\Request;

class EmailRule
{
    /**
     * @param  Request $request
     * @param  string  $key
     * @return bool
     */
    public function validate(Request $request, string $key) : bool
    {
        if (isset($request->$key)) {
            return filter_var($request->$key, FILTER_VALIDATE_URL);
        }

        return false;
    }

    /**
     * @param  string $attribute
     * @return string
     */
    public function message(string $attribute) : string
    {
        return "The $attribute must be a valid email address.";
    }
}
