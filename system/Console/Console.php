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

use Octopy\Support\Config;

class Console
{
    /**
     * @var array
     */
    protected $console = [];
        
    /**
     * @param  string      $command
     * @param  callable    $handler
     * @return Console
     */
    public function set(string $command, $handler) : Console
    {
        if (!isset($this->console[$command])) {
            array_push($this->console, [
                'command'     => $command,
                'handler'     => $handler,
                'description' => ''
            ]);
        }

        return $this;
    }

    /**
     * @param  string  $description
     * @return Console
     */
    public function describe(string $description = '')
    {
        $i = count($this->console) - 1;
        $this->console[$i]['description'] = $description;
    }

    /**
     * @param  string $command
     * @return Console
     */
    public function unset(string $command) : Console
    {
        foreach ($this->console as $i => $console) {
            if ($command === $console['command']) {
                unset($this->console[$i]);
            }
        }

        return $this;
    }

    /**
     * @param  string $file
     * @return Console
     */
    public function register(string $file)
    {
        require app('Route', $file);
    }

    /**
     * @return array
     */
    public function command() : array
    {
        asort($this->console);
        return $this->console;
    }
}
