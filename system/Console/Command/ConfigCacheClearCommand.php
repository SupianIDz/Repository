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

class ConfigCacheClearCommand extends Command
{
    /**
     * @var string
     */
    public $name = 'config:clear';

    /**
     * @var string
     */
    public $description = 'Remove the configuration cache file';

    /**
     * @param  Argv   $argv
     * @return string
     */
    public function handle(Argv $argv)
    {
        if (file_exists($cache = storage('framework', 'config.php'))) {
            unlink($cache);
        }

        return $this->success('Configuration cache cleared.', true);
    }
}
