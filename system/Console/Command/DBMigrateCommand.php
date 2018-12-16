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

use Octopy\Container;
use Octopy\Console\Argv;
use Octopy\Console\Command;

class DBMigrateCommand extends Command
{
    /**
     * @var string
     */
    public $name = 'db:migrate';

    /**
     * @var string
     */
    public $description = 'Run the database migrations';

    /**
     * @return void
     */
    public function handle(Argv $argv)
    {
        $directory = config('database.path.migration');
        
        foreach (scandir($directory) as $file) {
            if (is_dir($fullpath = $directory . $file)) {
                continue;
            }

            require_once $fullpath;
            $pieces = explode('_', substr($file, 0, -4));
            unset($pieces[0]);

            $migrations[] = implode('_', $pieces);
        }

        if (!empty($migrations)) {
            if ($argv->get('-r') || $argv->get('--refresh')) {
                foreach ($migrations as $migration) {
                    echo $this->warning('Rolling Back : %N%' . $migration, true);
                    Container::make($migration)->drop();
                    echo $this->success('Rolled Back  : %N%' . $migration, true);
                }

                echo $this->warning('-----------------------------------');
            }

            foreach ($migrations as $migration) {
                echo $this->warning('Migrating : %N%' . $migration, true);
                Container::make($migration)->create();
                echo $this->success('Migrated  : %N%' . $migration, true);
            }

            if ($argv->get('-s') || $argv->get('--seed')) {
                echo $this->warning('-----------------------------------');
                $seeder = new DBSeed;
                $seeder->handle($argv);
            }
        }
    }
}
