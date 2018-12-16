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

use ArrayIterator;
use JsonSerializable;
use IteratorAggregate;

use Octopy\Container;
use Octopy\Support\DB;

abstract class Model implements JsonSerializable, IteratorAggregate
{
    /**
     * @var Database
     */
    protected static $instance;

    /**
     * @var mixed
     */
    protected $result;

    /**
     * @param object $result
     */
    public function __construct($result = null)
    {
        $this->result = $result;
    }

    /**
     * @param  string $property
     * @return mixed
     */
    public function __get(string $property)
    {
        if (method_exists($this, $property)) {
            return $this->$property();
        }

        return $this->result->$property;
    }

    /**
     * @param  string $method
     * @param  array  $args
     * @return Model
     */
    public function __call(string $method, array $args = [])
    {
        return static::call($method, $args);
    }

    /**
     * @param  string $method
     * @param  array  $args
     * @return Model
     */
    public static function __callStatic(string $method, array $args = [])
    {
        return static::call($method, $args);
    }

    /**
     * @param  string $method
     * @param  array  $args
     * @return Model
     */
    private static function call(string $method, array $args = [])
    {
        $db = DB::table(function ($db) : string {
            $called = Container::make(
                $model = get_called_class()
            );

            $db->model($model);
         
            if (isset($called->table)) {
                return $called->table;
            }

            $array = explode(BS, $model);

            return strtolower(end($array));
        });

        return $db->$method(...$args);
    }

    /**
     * @param  string $model
     * @param  string $primary
     * @param  string $foreign
     * @return Database
     */
    public function link(string $model, string $primary, string $foreign)
    {
        $db = Container::make(DB::class);

        $db->table(function (Database $db) use ($model) : string {
            $called = Container::make($model);

            $db->model($model);
         
            if (isset($called->table)) {
                return $called->table;
            }

            $array = explode(BS, $model);

            return strtolower(end($array));
        });

        $this->link = $db->where($primary, $this->$foreign);

        return $this;
    }
    /**
     *
     * @return Database
     */
    public function single()
    {
        return $this->link->first();
    }

    /**
     * @return Database
     */
    public function multiple()
    {
        return $this->link->all();
    }

    /**
    * @return ArrayIterator
    */
    public function getIterator() : ArrayIterator
    {
        return new ArrayIterator($this->result);
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->result;
    }
}
