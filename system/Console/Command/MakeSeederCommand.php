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

class MakeSeederCommand extends Command
{
    /**
     * @var string
     */
    public $name = 'make:seeder';

    /**
     * @var string
     */
    public $description = 'Create a new seeder class';

    /**
     * @param  string $name
     * @return
     */
    public function handle(Argv $argv)
    {
        if ($name = $argv->get('name')) {
            $res = $this->dummy->extract($name . 'Seeder');

            $replace = array(
                'DummyClassName' => $res->classname
            );
            
            $this->dummy->mkdir($directory = config('database.path.seeder') . $res->directory);

            if ($this->dummy->exist($name = $directory . $res->classname . '.php')) {
                return $this->warning('Seeder already exists.', true);
            }

            if ($this->dummy->put($name, $this->dummy->stub('Seeder', $replace))) {
                return $this->success('Seeder created successfully.', true);
            }
        }
    }
}
