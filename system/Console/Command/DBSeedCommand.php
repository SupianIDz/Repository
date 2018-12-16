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

class DBSeedCommand extends Command
{
    /**
     * @var string
     */
    public $name = 'db:seed';

    /**
     * @var string
     */
    public $description = 'Seed the database with records';

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->directory = config('database.path.seeder');
    }

    /**
     * @return void
     */
    public function handle(Argv $argv)
    {
        $seeder = $argv->get('name') ?? 'DatabaseSeeder';
        return $this->call($seeder);
    }


    /**
     * @param  string $seeder
     * @return void
     */
    private function call(string $seeder)
    {
        echo $this->success('Seeding : %N%' . $seeder, true);

        require $this->directory . $seeder . '.php';

        $seeder = Container::make($seeder);
        $seeder->run();

        if (!empty($seeder->call)) {
            foreach ($seeder->call as $seeder) {
                $this->call($seeder);
            }
        }
    }
}
