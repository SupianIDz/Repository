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

class ConfirmedRule
{
    /**
     * @param  Request $request
     * @param  string  $key
     * @param  string  $confirm
     * @return bool
     */
    public function validate(Request $request, string $key, string $confirm) : bool
    {
        if (isset($request->$key) && isset($request->$confirm)) {
            return $request->$key == $request->$confirm;
        }

        return false;
    }

    /**
     * @param  string $attribute
     * @return string
     */
    public function message(string $attribute) : string
    {
        return "The $attribute confirmation does not match.";
    }
}
