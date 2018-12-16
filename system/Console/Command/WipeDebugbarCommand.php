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

class WipeDebugbarCommand extends Command
{
    /**
     * @var string
     */
    public $name = 'wipe:debugbar';

    /**
     * @var string
     */
    public $description = 'Clear all debugbar histories';

    /**
     * @return void
     */
    public function handle(Argv $argv)
    {
        $dir = config('debugbar.storage');
        foreach (scandir($dir) as $file) {
            if (is_file($dir . $file)) {
                echo $this->warning('Unlink Cache : %N%'. str_replace(BASEPATH, '/', $dir) . $file);
                unlink($dir . $file);
            }
        }
    }
}
