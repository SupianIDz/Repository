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

use Octopy\Support\DB;
use Octopy\HTTP\Request;

class UniqueRule
{
    /**
     * @param  Request $request
     * @param  string  $key
     * @param  string  $param
     * @return bool
     */
    public function validate(Request $request, string $key, string $param) : bool
    {
        $piece = explode(',', $param);
        
        $db = DB::table($piece[0]);
        $db->where($piece[1], $request->$key ?? null);

        return$db->count() < 1;
    }

    /**
     * @param  string $attribute
     * @return string
     */
    public function message(string $attribute) : string
    {
        return "The selected $attribute has already been taken.";
    }
}
