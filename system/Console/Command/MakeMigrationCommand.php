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
use Octopy\Support\Config;
use Octopy\Console\Command;

class MakeMigrationCommand extends Command
{
    /**
     * @var string
     */
    public $name = 'make:migration';

    /**
     * @var string
     */
    public $description = 'Create a new migration file';

    /**
     * @param  Argv   $argv
     * @return string
     */
    public function handle(Argv $argv)
    {
        if ($name = $argv->get('name')) {
            $res = $this->dummy->extract($name);

            $replace = array(
                'DummyTable'     => strtolower($name),
                'DummyClassName' => $res->classname,
                'DummyNameSpace' => $res->namespace
            );
            
            $this->dummy->mkdir($directory = config('database.path.migration') . $res->directory);

            $name = $directory . time() . '_' . $res->classname . '.php';

            if ($this->dummy->put($name, $this->dummy->stub('Migration', $replace))) {
                return $this->success('Migration created successfully.', true);
            }
        }
    }
}
