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

class GenerateKeyCommand extends Command
{
    /**
     * @var string
     */
    public $name = 'generate:key';

    /**
     * @var string
     */
    public $description = 'Set the application key';

    /**
     * @param  Argv   $argv
     * @return string
     */
    public function handle(Argv $argv)
    {
        if (!$this->dummy->exist($env = BASEPATH . '.env')) {
            $env = new GenerateEnvFile;
            echo $env->handle($argv);
        }

        $chars = array(
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'p',
            'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '1', '2', '3', '4', '5',
            '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
            'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
        );

        $string = '';

        for ($rand = 0; $rand <= 32; $rand++) {
            $random = rand(0, count($chars) - 1);
            $string .= $chars[$random];
        }

        file_put_contents($env, preg_replace_callback('/APP_KEY=(.*)/', function () use ($string) {
            return 'APP_KEY=' . $string;
        }, file_get_contents($env)));

        return $this->success('Application key set successfully.', true);
    }
}
