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

class BooleanRule
{
    /**
     * @param  Request $request
     * @param  string  $key
     * @return bool
     */
    public function validate(Request $request, string $key) : bool
    {
        if (isset($request->$key)) {
            return is_bool($request->$key);
        }

        return false;
    }

    /**
     * @param  string $attribute
     * @return string
     */
    public function message(string $attribute) : string
    {
        return "The $attribute field must be true or false.";
    }
}
