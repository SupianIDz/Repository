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

class MaxRule
{
    /**
     * @var null|string
     */
    private $unit = null;

    /**
     * @var int
     */
    private $max;

    /**
     * @param  Request $request
     * @param  string  $key
     * @param  int     $max
     * @return bool
     */
    public function validate(Request $request, string $key, int $max) : bool
    {
        $this->max = $max;

        if (isset($request->$key)) {
            if (is_array($request->$key) || is_object($request->$key)) {
                $this->unit = ' items';
                $value = count(is_array($request->$key) ? $request->$key : (array) $request->$key);
            } elseif (preg_match('/[a-zA-Z]/', $request->$key)) {
                $this->unit = ' characters';
                $value = strlen($request->$key);
            } else {
                $value = (int)$request->$key;
            }

            return $max > $value;
        }

        return false;
    }

    /**
     * @param  string $attribute
     * @return string
     */
    public function message(string $attribute) : string
    {
        return "The $attribute may not be greater than $this->max$this->unit.";
    }
}
