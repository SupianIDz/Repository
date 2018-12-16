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

namespace Octopy\Database;

use Octopy\Container;

class Connection
{
    /**
     * @var string
     */
    private $driver = [
        'mysql'  => Driver\MySQL::class,
        'pgsql'  => Driver\PgSQL::class,
        'sqlite' => Driver\SQLite::class
    ];

    /**
     * @var DriverInterface
     */
    private $instance;

    /**
     *
     */
    public function __destruct()
    {
        $this->instance = null;
    }
 
    /**
     * @param Driver
     */
    public function instance(string $driver = null)
    {
        $config = config('database');

        $driver = $driver ?? $config->default;
        if (isset($this->driver[$driver])) {
            if (!$this->instance instanceof $this->driver[$driver]) {
                $this->instance = Container::make($this->driver[$driver], (array)$config->connection->$driver);
            }

            return $this->instance;
        }
    }

    /**
     * @param  Driver $instance
     * @param  string $driver
     * @return bool
     */
    public function check($instance, string $driver) : bool
    {
        return $instance instanceof $this->driver[$driver];
    }
}
