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

namespace Octopy\Console;

use Closure;

use Octopy\Container;
use Octopy\Support\Console;

class Kernel
{
    /**
     * @var array
     */
    private $console = [];
    
    /**
     *
     */
    public function __construct()
    {
        new AutoDiscover(function () : void {
            $this->boot();
        });
    
        $this->common  = new Common;
        $this->console = Console::command();
    }

    /**
     * @param  Argv   $argv
     * @return string
     */
    public function handle(Argv $argv)
    {
        if (!$argv->command()) {
            $banner = $this->common->octopy();

            $this->common->header('Available Command :');
   
            foreach ($this->console as $i => $console) {
                if (preg_match('/\:/', $console['command'])) {
                    $list[] = $console;
                    continue;
                }
                
                $this->common->body($console['command'], $console['description']);
            }

            $group = [];

            foreach ($list as $i => $console) {
                list($prefix, $name) = explode(':', $console['command']);
                
                if (!in_array($prefix, $group)) {
                    $group[] = $prefix;
                    $this->common->group($prefix);
                }

                $this->common->body($console['command'], $console['description']);
            }


            return $banner . $this->common->display();
        }

        foreach ($this->console as $console) {
            if ($argv->command() == $console['command']) {
                if ($console['handler'] instanceof Closure) {
                    return $console['handler']($argv);
                }

                return Container::make($console['handler'])->handle($argv);
            }
        }
    }

    /**
     * @param string $response
     * @param Argv $argv
     */
    public function terminate(?string $response, Argv $argv)
    {
        echo $response;
        unset($argv);
    }
}
