<?php

/**
 *   ___       _
 *  / _ \  ___| |_ ___  _ __  _   _
 * | | | |/ __| __/ _ \| '_ \| | | |
 * | |_| | (__| || (_) | |_) | |_| |
 *  \___/ \___|\__\___/| .__/ \__, |
 *                 |_|    |___/
 * @author  : Supian M <supianidz@gmail.com>
 * @version : v1.0
 * @license : MIT
 */

namespace Octopy\Console;

class Output
{
    /**
     * @var array
     */
    private $style = [
        '%N%' => 0,
        '%S%' => 1,
        '%U%' => 4,
        '%B%' => 5,
        '%I%' => 6,
        '%H%' => 8,

        '%r%' => 31,
        '%g%' => 32,
        '%y%' => 33,
        '%b%' => 34,
        '%p%' => 35,
        '%c%' => 36,
        '%w%' => 37,
    ];

    /**
     * @param  string $string
     * @return string
     */
    public function output(string $string) : string
    {
        preg_match_all('^' . implode('|', array_keys($this->style)) . '^', $string, $match);
        $match[1] = [];
        foreach ($match[0] as $key) {
            $match[1][] = "\033[{$this->style[$key]}m";
        }

        return str_replace($match[0], $match[1], $string) . "\033[0m" . PHP_EOL;
    }

    /**
     * @param  string $string
     * @return string
     */
    public function success(string $string, bool $strong = false) : string
    {
        $format = '%g%';
        if ($strong == true) {
            $format .= '%S%';
        }

        return $this->output($format . $string);
    }

    /**
     * @param  string $string
     * @return string
     */
    public function info(string $string, bool $strong = false) : string
    {
        $format = '%c%';
        if ($strong == true) {
            $format .= '%S%';
        }

        return $this->output($format . $string);
    }

    /**
     * @param  string $string
     * @return string
     */
    public function warning(string $string, bool $strong = false) : string
    {
        $format = '%y%';
        if ($strong == true) {
            $format .= '%S%';
        }

        return $this->output($format . $string);
    }

    /**
     * @param  string $string
     * @return string
     */
    public function error(string $string, bool $strong = false) : string
    {
        $format = '%r%';
        if ($strong == true) {
            $format .= '%S%';
        }

        return $this->output($format . $string);
    }
}
