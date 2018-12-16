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

class ConfigCacheCommand extends Command
{
    /**
     * @var string
     */
    public $name = 'config:cache';

    /**
     * @var string
     */
    public $description = 'Create a cache file for faster configuration loading';

    /**
     * @param  Argv   $argv
     * @return string
     */
    public function handle(Argv $argv)
    {
        $files = scandir($basepath = app('Config'));

        $config = [];
        
        foreach ($files as $file) {
            if (is_dir($basepath . $file)) {
                continue;
            }

            $key = strtolower(substr($file, 0, -4));
            $config[$key] = require $basepath . $file;
        }

        $replace = array(
            'DummyConfig' => var_export($config, true)
        );


        if ($this->dummy->put(storage('framework', 'config.php'), $this->dummy->stub('Config', $replace))) {
            return $this->success('Configuration cached successfully.', true);
        }
    }
}
