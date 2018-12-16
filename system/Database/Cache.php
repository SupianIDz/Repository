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

final class Cache
{
    /**
     * @param string $query
     * @param int    $lifetime
     */
    public function __construct(string $query, int $lifetime)
    {
        $this->query    = $query;
        $this->lifetime = $lifetime;
    }

    /**
     * @return string
     */
    public function cache() : string
    {
        if (!is_dir($dir = config('database.path.cache'))) {
            mkdir($dir, 0755, true);
        }

        return $dir . md5($this->query) . '.json';
    }

    /**
     * @return object
     */
    public function load()
    {
        return json_decode(file_get_contents($this->cache()));
    }

    /**
     * @param  array  $data
     */
    public function write(array $data)
    {
        $data = array_merge([
            'query'    => $this->query,
            'generate' => date('d-M-Y, H:i:s')
        ], $data);

        file_put_contents($this->cache(), json_encode($data));
    }

    /**
     * @return bool
     */
    public function check() : bool
    {
        if (!file_exists($cache = $this->cache())) {
            return true;
        }

        return (filemtime($cache) + config('database.cache.lifetime')) < time();
    }
}
