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

namespace Octopy\Console;

use Closure;
use RecursiveDirectoryIterator as RDIterator;

use Octopy\Container;
use Octopy\Support\Console;

class AutoDiscover
{
    /**
     * @var array
     */
    private $namespace = [
        'App\Console\Command',
        'Octopy\Console\Command'
    ];

    /**
     *
     */
    public function __construct($closure)
    {
        $namespaces = json_decode(file_get_contents(BASEPATH . 'octopy.json'))->autoload->psr;
        
        if ($closure instanceof Closure) {
            $closure();
        }

        foreach ($namespaces as $namespace => $directory) {
            $this->merge(
                $namespace . BS . 'Console\\Command\\',
                basepath($directory . '.Console.Command')
            );
        }
    }

    /**
     * @param  string $namespace
     * @param  string $dirname
     */
    private function merge(string $namespace, string $dirname)
    {
        if (!is_dir($dirname)) {
            return;
        }

        $iterator = new RDIterator($dirname, RDIterator::SKIP_DOTS);
        foreach ($iterator as $file) {
            if (!$file->isFile()) {
                continue;
            }

            require $file;

            $instance = Container::make($class = $namespace . substr($file->getFileName(), 0, -4));

            Console::set($instance->name, $class)->describe($instance->description);
        }
    }
}
