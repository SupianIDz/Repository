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

use stdClass;

class SystemLoader
{
    /**
     * @var array
     */
    private $extensions = ['.php', '.octopy', '.octopy.php'];

    /**
     * @param object $path
     */
    public function __construct(stdClass $path)
    {
        $this->path = $path;
        $this->path->resource[] = octopy('Debug.Resource');
    }

    /**
     * @param  string $template
     * @return string
     */
    public function load(string $template) : string
    {
        $template = preg_replace('/\./', DS, $template);

        foreach ($this->path->resource as $path) {
            foreach ($this->extensions as $ext) {
                if (file_exists($path . $template . $ext)) {
                    return $this->template = $path . $template . $ext;
                }
            }
        }

        throw new Exception\TemplateNotExistException;
    }

    /**
     * @return string
     */
    public function cache() : string
    {
        if (!is_dir($compiled = $this->path->compiled)) {
            mkdir($compiled, 0755, true);
        }

        return $compiled . md5($this->template) . '.php';
    }

    /**
     * @return string
     */
    public function html() : string
    {
        if (!is_dir($compiled = $this->path->compiled)) {
            mkdir($compiled, 0755, true);
        }

        return $compiled . md5($this->template) . '.html';
    }
}
