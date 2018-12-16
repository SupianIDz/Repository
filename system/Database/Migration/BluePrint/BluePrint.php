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

interface BluePrint
{
    /**
     * @param string $table
     */
    public function table(string $table);

    /**
     * @return BluePrint
     */
    public function primary();

    /**
     * @return BluePrint
     */
    public function unique();

    /**
     * @return BluePrint
     */
    public function index();

    /**
     * @param  string    $name
     * @return BluePrint
     */
    public function increment(string $name);

    /**
     * @param  string    $name
     * @return BluePrint
     */
    public function integer(string $name);

    /**
     * @param  string      $name
     * @param  int|integer $length
     * @return BluePrint
     */
    public function string(string $name, int $length = 255);

    /**
     * @param  string    $name
     * @return BluePrint
     */
    public function text(string $name);

    /**
     * @param  string    $name
     * @param  array     $data
     * @return BluePrint
     */
    public function enum(string $name, array $data);

    /**
     * @param  string $name
     * @return BluePrint
     */
    public function time(string $name);

    /**
     * @param  string $name
     * @return BluePrint
     */
    public function date(string $name);

    /**
     * @param  string $name
     * @return BluePrint
     */
    public function year(string $name);

    /**
     * @param  string $name
     * @return BluePrint
     */
    public function datetime(string $name);

    /**
     * @param  string $name
     * @return BluePrint
     */
    public function timestamp(string $name);

    /**
     * @param  string    $default
     * @return BluePrint
     */
    public function default($default = 'NULL');

    /**
     * @param  string    $parent
     * @param  string    $primary
     * @return BluePrint
     */
    public function foreign(string $parent, string $primary);

    /**
     * @param  string    $option
     * @return BluePrint
     */
    public function update(string $option);

    /**
     * @param  string    $option
     * @return BluePrint
     */
    public function delete(string $option);

    /**
     * @return BluePrint
     */
    public function unsigned();

    /**
     * @param  string    $name
     * @param  string    $query
     * @return BluePrint
     */
    public function set(string $name, string $query);

    /**
     * @return string
     */
    public function build() : string;
}
