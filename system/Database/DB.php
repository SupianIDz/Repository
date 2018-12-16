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

use PDO;
use Closure;
use PDOException;
use ArrayIterator;
use JsonSerializable;
use IteratorAggregate;

use Octopy\Container;
use Octopy\Database\Connection;

class DB implements JsonSerializable, IteratorAggregate
{
    /**
     * @var Driver
     */
    protected $driver;

    /**
     * @var string
     */
    protected $model;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $query;

    /**
     * @var mixed
     */
    protected $result;

    /**
     * @var array
     */
    protected static $debugbar = [];

    /**
     *
     */
    public function __construct()
    {
        $this->driver();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->result;
    }

    /**
     * @param  string $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->result->$property;
    }
    
    /**
     * @param  string $driver
     * @return DB
     */
    public function driver(string $driver = null)
    {
        $connection = Container::make(Connection::class);
        if ($this->driver && $connection->check($this->driver, $driver)) {
            return $this;
        }

        if ($this->driver && !$connection->check($this->driver, $driver)) {
            $this->close();
        }

        $this->driver = $connection->instance($driver);
        unset($connection);
        return $this;
    }

    /**
     * @param  string $model
     * @return DB
     */
    public function model(string $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @param  string $table
     * @return DB
     */
    public function table($table)
    {
        if ($table instanceof Closure) {
            return $this->table(call_user_func($table, $this));
        }

        $this->table = trim($table);
        return $this;
    }

    /**
     * @param  string $query
     * @return DB
     */
    public function query(string $query)
    {
        $this->query = $query;
        return $this->run();
    }

    /**
    * @param  array $column
    * @return DB
    */
    public function select(array $column)
    {
        foreach ($column as $i => $col) {
            if ($col === '*') {
                continue;
            }
                
            $column[$i] = $this->escape($col);
        }

        $this->query = null;
        $this->reset('SELECT %s FROM %s', [implode(', ', $column), $this->escape($this->table)]);
        unset($this->table);
        return $this;
    }

    /**
     * @param  string $column
     * @param  string $value
     * @param  string $operator
     * @return DB
     */
    public function where(string $column, $value, string $operator = '=')
    {
        if (!$this->check('WHERE')) {
            return $this->set('WHERE %s %s %s', [
                $this->escape($column),
                strtoupper($operator),
                $this->escape($value, 0)
            ]);
        }

        return $this->set('AND %s %s %s', [
            $this->escape($column),
            strtoupper($operator),
            $this->escape($value, 0)
        ]);
    }

    /**
     * @param  string $column
     * @param  string $value
     * @param  string $operator
     * @return DB
     */
    public function and(string $column, $value, string $operator = '=')
    {
        return $this->where($column, $value, $operator);
    }

    /**
     * @param  string $column
     * @param  string $value
     * @param  string $operator
     * @return DB
     */
    public function or(string $column, $value, string $operator = '=')
    {
        if (!$this->check('WHERE')) {
            return $this->where($column, $value, $operator);
        }

        return $this->set('OR %s %s %s', [
            $this->escape($column),
            strtoupper($operator),
            $this->escape($value, 0)
        ]);
    }

    /**
     * @param  array $data
     * @return DB
     */
    public function insert(array $data)
    {
        foreach ($data as $col => $val) {
            $column[] = $this->escape($col);
            $values[] = $this->escape($val, 0);
        }

        $this->reset('INSERT INTO %s (%s) VALUES (%s)', [
            $this->escape($this->table),
            implode(', ', $column),
            implode(', ', $values)
        ]);

        unset($this->table);

        if ($this->execute()) {
            $this->result(true);
        }

        return $this;
    }

    /**
     * @return DB
     */
    public function id()
    {
        return $this->result($this->driver->lastInsertId());
    }

    /**
     * @param  array  $data
     * @return DB
     */
    public function update(array $data)
    {
        foreach ($data as $column => $value) {
            $query[] = $this->escape($column) . ' = ' . $this->escape($value, 0);
        }

        $this->reset('UPDATE %s SET %s %s', [
            $this->escape($this->table),
            implode(', ', $query),
            trim($this->query)
        ]);

        unset($this->table);

        if ($this->execute()) {
            $this->result(true);
        }

        return $this;
    }

    /**
     * @param  array  $data
     * @return DB
     */
    public function increase(array $data)
    {
        foreach ($data as $column => $value) {
            $query[] = $this->escape($column) . ' = ' . $this->escape($column) . ' + ' . $value;
        }

        $this->reset('UPDATE %s SET %s', [
            $this->escape($this->table),
            implode(', ', $query),
            trim($this->query)
        ]);

        unset($this->table);

        if ($this->execute()) {
            $this->result(true);
        }

        return $this;
    }

    /**
     * @param  array  $data
     * @return DB
     */
    public function decrease(array $data)
    {
        foreach ($data as $column => $value) {
            $query[] = $this->escape($column) . ' = ' . $this->escape($column) . ' - ' . $value;
        }

        $this->reset('UPDATE %s SET %s', [
            $this->escape($this->table),
            implode(', ', $query),
            trim($this->query)
        ]);

        unset($this->table);

        if ($this->execute()) {
            $this->result(true);
        }

        return $this;
    }

    /**
     * @return DB
     */
    public function delete()
    {
        $this->reset('DELETE FROM %s %s', [
            $this->escape($this->table),
            trim($this->query)
        ]);

        unset($this->table);

        if ($this->execute()) {
            $this->result(true);
        }

        return $this;
    }

    /**
     * @param  int $limit
     * @return DB
     */
    public function limit(int $limit = 1)
    {
        return $this->set('LIMIT %s', $limit);
    }

    /**
     * @param  int $start
     * @param  int $end
     * @return DB
     */
    public function offset(int $start, int $end)
    {
        return $this->limit($start)->reset('%s, %s', [
            trim($this->query),
            $end
        ]);
    }

    /**
     * @return DB
     */
    public function get()
    {
        if (!$this->check('SELECT')) {
            $this->reset('SELECT * FROM %s %s', [
                $this->escape($this->table),
                trim($this->query)
            ]);
        }

        unset($this->table);

        if ($pdo = $this->execute()) {
            if (!empty($fetch = $pdo->fetchAll())) {
                foreach ($fetch as $row) {
                    $result[] = $this->instance($row);
                }

                $this->result($result);
            }
        }

        return $this->result;
    }

    /**
     * @return DB
     */
    public function all()
    {
        return $this->get();
    }

    /**
    * @return DB
    */
    public function first()
    {
        $this->limit(1);
       
        if (!$this->check('SELECT')) {
            $this->reset('SELECT * FROM %s %s', [
                $this->escape($this->table),
                $this->query
            ]);
        }

        unset($this->table);

        if ($pdo = $this->execute()) {
            if ($result = $pdo->fetch()) {
                $this->result($this->instance($result));
            }
        }

        return $this;
    }

    /**
     * @return DB
     */
    public function last()
    {
        $this->get();
        if ($this->count() !== 0) {
            $this->result(
                $this->instance(
                    end($this->result)
                )
            );
        }

        return $this;
    }

    /**
     * @return int
     */
    public function count() : int
    {
        $this->get();
        if (is_array($this->result)) {
            return count($this->result);
        }

        return $this->result !== null ? 1 : 0;
    }

    /**
     * @return void
     */
    public function close()
    {
        $this->query  = null;
        $this->result = null;
        $this->driver = null;
    }

    /**
     * @param  mixed $data
     * @return instanceof Model
     */
    protected function instance($data = null)
    {
        if (!$this->model) {
            return $data;
        }

        $instance = Container::resolve($this->model, [$data]);
        foreach (get_object_vars($instance) as $property => $value) {
            if ($property !== 'result') {
                unset($driver->$property);
            }
        }

        return $instance;
    }

    /**
     * @param string $format
     * @param array  $data
     */
    protected function set(string $format, $data)
    {
        if (!is_array($data)) {
            $data = [$data];
        }

        $this->query .= sprintf($format . ' ', ...$data);
        return $this;
    }

    /**
     * @param string $format
     * @param array  $data
     */
    protected function reset(string $format, $data)
    {
        if (!is_array($data)) {
            $data = [$data];
        }

        $this->query = sprintf($format . ' ', ...$data);
        return $this;
    }

    /**
     * @param  mixed $result
     * @return DB
     */
    protected function result($result = null)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return PDO
     */
    public function execute()
    {
        try {
            $start = microtime(true);
            $query = $this->driver->prepare($sql = trim($this->query));
            
            if ($query->execute()) {
                DB::$debugbar[] = array(
                    'query'  => $sql,
                    'status' => true,
                    'time'   => microtime(true) - $start,
                    'memory' => memory_get_peak_usage()
                );

                return $query;
            }

            DB::$debugbar[] = array(
                'query'  => $sql,
                'status' => false,
                'time'   => microtime(true) - $start,
                'memory' => memory_get_peak_usage()
            );

            return false;
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage());
        }
    }

    /**
     * @return PDO
     */
    public function run()
    {
        return $this->execute();
    }

    /**
     * @return array
     */
    public static function debugbar() : array
    {
        return DB::$debugbar;
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

    /**
     * @param  string $pattern
     * @return DB
     */
    protected function check(string $pattern)
    {
        return preg_match('/' . $pattern .'/', $this->query);
    }

    /**
     * @param  mixed  $value
     * @param  bool   $escape
     * @return string
     */
    protected function escape($value, bool $escape = true)
    {
        if (!is_string($value)) {
            return $value;
        }

        if ($escape) {
            if ($this->driver instanceof DB\Driver\PgSQL) {
                return preg_replace('/[^0-9A-Za-z^_-]/', '', trim($value));
            }

            return '`' . preg_replace('/[^0-9A-Za-z^_-]/', '', trim($value)) . '`';
        }

        return "'" . stripslashes($value) . "'";
    }

    /**
     * @param  string $pattern
     * @return string
     */
    protected function match(string $pattern) : ?string
    {
        preg_match('/' . $pattern . '/', $this->query, $matches);

        if (empty($matches)) {
            return null;
        }

        return $matches[0];
    }
}
