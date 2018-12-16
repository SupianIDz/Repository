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

class MakeControllerCommand extends Command
{
    /**
     * @var string
     */
    public $name = 'make:controller';

    /**
     * @var string
     */
    public $description = 'Create a new controller class';

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
            
            $this->dummy->mkdir($directory = app('HTTP.Controller.' . $res->directory));

            if ($this->dummy->exist($name = $directory . $res->classname . '.php')) {
                return $this->warning('Controller already exists.', true);
            }

            $stub = 'Controller';
            if ($argv->get('-r') || $argv->get('--resource')) {
                $stub .= 'Resource';
            }

            if ($this->dummy->put($name, $this->dummy->stub($stub, $replace))) {
                return $this->success('Controller created successfully.', true);
            }
        }
    }
}
