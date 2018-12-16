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

namespace Octopy\Common;

use Octopy\Support\Config;
use Octopy\Support\Session;

class Auth
{
    /**
     * @var string
     */
    protected $provider;

    /**
     * @var object
     */
    protected $query;

    /**
     * @param  array $data
     * @return Auth
     */
    public function attempt(array $data)
    {
        if (!$this->provider) {
            $this->provider();
        }

        foreach ($data as $col => $val) {
            $column[] = $col;
            $values[] = $val;
        }

        $query = $this->provider::where($column[0], $value[0])->first();
    
        if (count($query) < 1) {
            Session::unset('OCTOPY_AUTH');
            return false;
        }

        if (!password_verify($column[1], $query->{$column[1]})) {
            Session::unset('OCTOPY_AUTH');
            return false;
        }

        unset($query->{$column[1]});

        Session::set('OCTOPY_AUTH', json_encode($query));

        return $this;
    }

    /**
     * @return bool
     */
    public function check() : bool
    {
        if (Session::isset('OCTOPY_AUTH') && is_object($this->data())) {
            return true;
        }

        return false;
    }

    /**
     * @return void
     */
    public function destroy()
    {
        Session::unset('OCTOPY_AUTH');
    }

    /**
     * @return object
     */
    public function data()
    {
        return json_decode(Session::get('OCTOPY_AUTH'));
    }

    /**
     * @param  string|null $provider
     * @return Auth
     */
    public function provider(string $provider = null)
    {
        $this->provider = config('auth.providers.default');

        if (!is_null($provider)) {
            $this->provider = config('auth.provider.' . $provider);
        }

        return $this;
    }
}
