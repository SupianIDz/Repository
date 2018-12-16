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

class MakeModelCommand extends Command
{
    /**
     * @var string
     */
    public $name = 'make:model';

    /**
     * @var string
     */
    public $description = 'Create a new model class';

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
            
            $this->dummy->mkdir($directory = app('DB' . $res->directory));

            if ($this->dummy->exist($name = $directory . $res->classname . '.php')) {
                return $this->warning('Model already exists.', true);
            }

            if ($this->dummy->put($name, $this->dummy->stub('Model', $replace))) {
                echo $this->success('Model created successfully.', true);
            }

            if ($argv->get('-a') || $argv->get('--all') || $argv->get('-m') || $argv->get('--migration')) {
                $migration = new MakeMigration;
                echo $migration->handle($argv);
            }

            if ($argv->get('-a') || $argv->get('--all') || $argv->get('-s') || $argv->get('--seeder')) {
                $seeder = new MakeSeeder;
                echo $seeder->handle($argv);
            }
        }
    }
}
