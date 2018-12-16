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

class WipeCacheCommand extends Command
{
    /**
     * @var string
     */
    public $name = 'wipe:cache';

    /**
     * @var string
     */
    public $description = 'Clear all compiled files';

    /**
     * @return void
     */
    public function handle(Argv $argv)
    {
        $directory = config('view.path.compiled');
        foreach (scandir($directory) as $file) {
            if (is_file($directory . $file)) {
                echo $this->warning('Unlink Cache : %N%'. str_replace(BASEPATH, '/', $directory) . $file);
                unlink($directory . $file);
            }
        }
    }
}
