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

namespace Octopy\Database\Migration;

use Closure;
use PDOException;

use Octopy\Container;
use Octopy\Support\DB;
use Octopy\Support\Config;

class Schema
{
    /**
     * @var string
     */
    private $migration;

    /**
     * @var DB
     */
    private $database;

    /**
     * @var string
     */
    private $driver = [
        'mysql'  => BluePrint\MySQL::class,
        'pgsql'  => BluePrint\PgSQL::class,
        'sqlite' => BluePrint\SQLite::class
    ];

    /**
     * @param  string $driver
     * @return Schema
     */
    public function driver(string $driver = null)
    {
        if (isset($this->driver[$driver])) {
            $this->database  = DB::driver($driver);
            $this->migration = Container::make($this->driver[$driver]);
        }

        return $this;
    }

    /**
     * @param string  $table
     * @param Closure $fallback
     */
    public function create(string $table, Closure $fallback)
    {
        if (!$this->migration) {
            $this->driver(Config::get('database.default'));
        }

        if ($fallback instanceof Closure) {
            $fallback(
                $query = $this->migration->table($table)
            );

            $this->database->query($query->build());
        }
    }

    /**
     * @param string $table
     */
    public function drop(string $table)
    {
        if (!$this->migration) {
            $this->driver(Config::get('database.default'));
        }

        $this->database->query($this->migration->table($table)->drop());
    }
}
