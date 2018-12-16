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

use RecursiveDirectoryIterator as RDIterator;

class Config
{
    /**
     * @var array
     */
    private $config = [];
    
    /**
     *
     */
    public function __construct()
    {
        if (!file_exists($cache = storage('framework', 'config.php'))) {
            $iterator = new RDIterator(app('Config'), RDIterator::SKIP_DOTS);
            foreach ($iterator as $config) {
                $name = strtolower(substr($config->getFileName(), 0, -4));
                $this->config[$name] = require $config;
            }
        } else {
            $this->config = require $cache;
        }
    }

    /**
     * @param  string $key
     * @return bool
     */
    public function exist(string $key) : bool
    {
        $config = $this->config;

        foreach (explode('.', $key) as $no => $key) {
            if (array_key_exists($key, $config)) {
                $config = $config[$key];
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * @param  string $key
     * @return mixed
     */
    public function get(string $key, bool $object = true)
    {
        $config = $this->config;

        foreach (explode('.', $key) as $no => $key) {
            if (array_key_exists($key, $config)) {
                $config = $config[$key];
            } else {
                throw new Config\Exception\ConfigKeyNotExistException($key);
            }
        }

        if ($object) {
            return is_array($config) ? json_decode(json_encode($config)) : $config;
        }
        
        return $config;
    }
}
