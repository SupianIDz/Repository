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

namespace Octopy\Engine;

use Octopy\Engine;
use Octopy\Support\Config;

class View
{
    /**
     * @var array
     */
    private $data = [];
    
    /**
     *
     */
    public function __construct()
    {
        $config = Config::get('view');
        $this->engine = new Engine(new SystemLoader($config->path), $config->output);
    }

    /**
     * @param  string $template
     * @param  array  $data
     * @return string
     */
    public function render(string $template, array $data = [], bool $static = null, bool $minify = false)
    {
        return $this->engine->render($template, array_merge_recursive($this->data, $data), $static, $minify);
    }

    /**
     * @return array
     */
    public function debugbar()
    {
        return $this->engine->debugbar();
    }

    /**
     * @param  string $var
     * @param  mixed  $value
     * @return View
     */
    public function data($var, $value = null)
    {
        if (is_array($var)) {
            foreach ($var as $key => $value) {
                $this->data($key, $value);
            }

            return $this;
        }

        $this->data[$var] = $value;

        return $this;
    }
}
