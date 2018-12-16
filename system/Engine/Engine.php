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

namespace Octopy;

use Closure;
use stdClass;

use Octopy\Engine\Compiler;
use Octopy\Engine\SystemLoader;

class Engine
{
    /**
     * @var Loader
     */
    private $loader;

    /**
     * @var Compiler
     */
    private $compiler;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var object
     */
    private $output;

    /**
     * @var string
     */
    private $parent;

    /**
     * @var array
     */
    private $section = [];

    /**
     * @var array
     */
    private $block = [];

    /**
     * @var array
     */
    private $debugbar = [];

    /**
     * @var array
     */
    private $collector = [];

    /**
     * @var float
     */
    private $state = 0;
        
    /**
     * @param Loader $loader
     * @param object $output
     */
    public function __construct(SystemLoader $loader, stdClass $output)
    {
        $this->loader = $loader;
        $this->output = $output;
        $this->compiler = new Compiler;
    }

    /**
     * @param  string $template
     * @param  array  $data
     * @return string
     */
    public function render(string $template, array $data, bool $static = null, bool $minify = false)
    {
        $this->data = $data;
        
        $this->collector['startime'][$this->state] = microtime(true);
        $this->collector['template'][$this->state] = $this->template = $this->loader->load($template);
        $this->state++;

        $static = !is_null($static) ? $static : config('view.static.enable');
        if ($static == true) {
            if ($this->check('static')) {
                $result = $this->compile($minify, function ($html) {
                    file_put_contents($this->loader->html(), $html);
                });
            } else {
                $result = file_get_contents($this->loader->html());
            }
        } else {
            $result = $this->compile($minify);
        }
        
        $this->state--;

        $this->debugbar[] = [
            'template' => $this->collector['template'][$this->state],
            'time'     => microtime(true) - $this->collector['startime'][$this->state],
            'memory'   => memory_get_peak_usage()
        ];

        return $result;
    }

    /**
     * @return array
     */
    public function debugbar()
    {
        return $this->debugbar;
    }

    /**
     * @return string
     */
    private function compile(bool $minify = false, Closure $closure = null) : string
    {
        if ($this->check('dynamic')) {
            $compiled = $this->compiler->compile($this, function ($compiled) {
                file_put_contents($this->loader->cache(), $compiled);
                return $compiled;
            });
        } else {
            $compiled = file_get_contents($this->loader->cache());
        }

        $html = $this->evaluate($compiled);

        if ($this->output->minify || $minify) {
            $html = Support\Minify::html($html);
        }

        if ($this->output->encode) {
            $html = Support\Minify::encode($html);
        }

        if ($closure instanceof Closure) {
            call_user_func($closure, $html);
        }

        return $html;
    }

    /**
     * @param  string $template
     * @return void
     */
    private function extend(string $template)
    {
        $this->parent = $template;
    }

    /**
     * @param string $file
     */
    private function include(string $file)
    {
        $this->render($file, $this->data);
        include($this->loader->cache());
    }

    /**
     * @param string $file
     */
    private function require(string $file)
    {
        $this->render($file, $this->data);
        require($this->loader->cache());
    }

    /**
     * @return string
     */
    private function display()
    {
        echo $this->render($this->parent, $this->data);
    }

    /**
     * @param  string      $name
     * @param  string|null $default
     * @return string
     */
    private function section(string $name, string $default = null)
    {
        return $this->block[$name] ?? $default;
    }

    /**
     * @param  string $name
     * @param  string $value
     * @return void
     */
    private function block(string $name, string $value = null)
    {
        ob_start();
        if (!isset($this->block[$name])) {
            $this->block[$name] = $value;
        }

        $this->open[] = $name;
    }

    /**
     * @return void
     */
    private function endblock()
    {
        $name = array_pop($this->open);
        $value = ob_get_clean();
        if ($this->block[$name] === null) {
            $this->block[$name] = $value;
        }
    }

    /**
     * @return bool
     */
    private function check(string $type)
    {
        if ($type == 'dynamic') {
            if (!file_exists($compiled = $this->loader->cache())) {
                return true;
            }

            return filemtime($this->template) > filemtime($compiled);
        }

        if (!file_exists($static = $this->loader->html())) {
            return true;
        }

        if (filemtime($static) + config('view.static.lifetime') < time()) {
            return true;
        }

        return filemtime($this->template) > filemtime($static);
    }

    /**
     * @param  string $source
     * @return string
     */
    private function evaluate(string $source)
    {
        try {
            extract($this->data);
            ob_start();
            eval(';?>' . $source);
            return ob_get_clean();
        } catch (Exception $e) {
            throw new Exception;
        }
    }
}
