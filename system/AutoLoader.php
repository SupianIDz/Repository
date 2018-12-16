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

namespace Octopy;

use Closure;
use RuntimeException;

final class AutoLoader
{
    /**
     * @var string
     */
    protected $config = 'octopy.json';

    /**
     *
     */
    public function __construct()
    {
        $config = json_decode(file_get_contents(BASEPATH . $this->config));

        if (!isset($config->autoload->psr)) {
            throw new RuntimeException;
        }

        spl_autoload_register(function ($class) use ($config) {
            foreach ($config->autoload->psr as $namespace => $directory) {
                if ($path = $this->search($class, $namespace, $directory)) {
                    return $path;
                }
            }
        });

        if (isset($config->autoload->files)) {
            foreach ($config->autoload->files as $file) {
                $this->load($file);
            }
        }
    }

    /**
     * @param array $aliases
     */
    public function class($aliases = [])
    {
        if ($aliases instanceof Closure) {
            return $this->class(call_user_func($aliases));
        }

        foreach ($aliases['class'] as $alias => $class) {
            class_alias($class, $alias);
        }
    }

    /**
     * @param  string $class
     * @param  string $namespace
     * @param  string $directory
     * @return string
     */
    protected function search(string $class, string $namespace, string $directory) : string
    {
        $path = BASEPATH . str_replace([$namespace, BS], [$directory, DS], $class) . '.php';
        if ($this->load($path)) {
            return $path;
        }

        $pieces   = explode(DS, substr($path, 0, -4));
        $pieces[] = end($pieces);

        $path = implode(DS, $pieces) . '.php';
        if ($this->load($path)) {
            return $path;
        }

        return false;
    }

    /**
     * @param  string $path
     * @return bool
     */
    protected function load(string $path) : bool
    {
        if (file_exists($path)) {
            return require_once $path;
        }

        return false;
    }
}
