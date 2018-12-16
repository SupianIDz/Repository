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
use Octopy\Support\Route;
use Octopy\Console\Common;
use Octopy\Console\Command;
use Octopy\Console\Common\CLITable;

class RouteListCommand extends Command
{
    /**
     * @var string
     */
    public $name = 'route:list';

    /**
     * @var string
     */
    public $description = 'List all registered routes';

    /**
     * @param  Argv   $argv
     * @return string
     */
    public function handle(Argv $argv)
    {
        Container::make(\App\HTTP\Kernel::class);

        $table = new CLITable;
        $table->tcolor('white');
        $table->hcolor('green');

        $table->add('Method', 'method', 'white');
        $table->add('URI', 'target', 'white');
        $table->add('Name', 'name', 'white');
        $table->add('Action', 'action', 'white');
        $table->add('Middleware', 'middleware', 'white');
        
        $table->data(Route::data());
        
        $table->display();
    }
}
