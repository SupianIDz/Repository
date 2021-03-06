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

namespace Octopy\Database\Driver;

use PDO;
use PDOException;

class MySQL extends PDO
{
    /**
     * @param string $hostname
     * @param string $database
     * @param string $username
     * @param string $password
     */
    public function __construct(string $hostname, string $database, string $username, string $password)
    {
        try {
            parent::__construct("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password, [
                PDO::ATTR_PERSISTENT         => true,
                PDO::ATTR_CASE               => PDO::CASE_LOWER,
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_WARNING,
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ]);
        } catch (PDOException $exception) {
            throw new PDOException;
        }
    }
}
