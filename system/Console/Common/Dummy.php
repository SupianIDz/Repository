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

namespace Octopy\Console\Common;

use stdClass;

class Dummy
{
    /**
     * @param  string $name
     * @param  array  $data
     * @return string
     */
    public function stub(string $name, array $data = null)
    {
        $content = file_get_contents(sprintf('%s/Dummy/%s.stub', __DIR__, $name));
        
        if (!is_null($data)) {
            if (isset($data['DummyNameSpace']) && $data['DummyNameSpace'] === '') {
                unset($data['DummyNameSpace']);
                $data['\DummyNameSpace'] = '';
            }

            return str_replace(array_keys($data), array_values($data), $content);
        }

        return $content;
    }

    /**
     * @param  string $string
     * @return stdClass
     */
    public function extract(string $string) : stdClass
    {
        preg_match('/(.*)\/(.*)/', trim($string, '/'), $match);
        
        $std = new stdClass;
        $std->directory = $match[1] ?? '';
        $std->classname = $match[2] ?? $string;
        $std->namespace = str_replace(DS, BS, $match[1] ?? '');
        
        return $std;
    }

    /**
     * @param  string $path
     * @param  string $content
     * @return int
     */
    public function put(string $path, string $content) : int
    {
        return file_put_contents($path, $content);
    }

    /**
     * @param  string $directory
     */
    public function mkdir(string $directory)
    {
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }

    /**
     * @param  string $path
     * @return bool
     */
    public function exist(string $path) : bool
    {
        return file_exists($path);
    }
}
