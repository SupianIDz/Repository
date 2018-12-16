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

class ServeCommand extends Command
{
    /**
     * @var string
     */
    public $name = 'serve';

    /**
     * @var string
     */
    public $description = 'Serve the application on the PHP development server';

    /**
     * @return void
     */
    public function handle(Argv $argv)
    {
        $root = basepath('public');

        $port = $argv->get('--port') ? $argv->get('--port') : 8000;

        echo $this->warning('Octopy development server started :%w% http://127.0.0.1:' . $port, true);

        system('cd ' . $root . ' && php -S 127.0.0.1:' . $port);
    }
}
