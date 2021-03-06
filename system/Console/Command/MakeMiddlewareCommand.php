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

namespace Octopy\Console\Command;

use Octopy\Console\Argv;
use Octopy\Console\Command;

class MakeMiddlewareCommand extends Command
{
    /**
     * @var string
     */
    public $name = 'make:middleware';

    /**
     * @var string
     */
    public $description = 'Create a new middleware class';

    /**
     * @param  Argv   $argv
     * @return string
     */
    public function handle(Argv $argv)
    {
        if ($name = $argv->get('name')) {
            $res = $this->dummy->extract($name);

            $replace = array(
                'DummyClassName' => $res->classname,
                'DummyNameSpace' => $res->namespace
            );
            
            $this->dummy->mkdir($directory = app('HTTP.Middleware.' . $res->directory));

            if ($this->dummy->exist($name = $directory . $res->classname . '.php')) {
                return $this->warning('Middleware already exists.', true);
            }

            if ($this->dummy->put($name, $this->dummy->stub('Middleware', $replace))) {
                return $this->success('Middleware created successfully.', true);
            }
        }
    }
}
