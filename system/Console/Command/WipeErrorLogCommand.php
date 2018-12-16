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

use RecursiveDirectoryIterator as RDIterator;

use Octopy\Console\Argv;
use Octopy\Console\Command;

class WipeErrorLogCommand extends Command
{
    /**
     * @var string
     */
    public $name = 'wipe:log';

    /**
     * @var string
     */
    public $description = 'Clear all error log';

    /**
     * @return void
     */
    public function handle(Argv $argv)
    {
        file_put_contents(storage('framework', 'octopy.log'), '');
        return $this->success('Error logs cleared.', true);
    }
}
