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

class Common extends Output
{
    /**
     * @param array $data
     */
    public function table(array $data)
    {
        $column = [];
        foreach ($data as $rkey => $row) {
            foreach ($row as $ckey => $cell) {
                $length = strlen($cell);
                if (empty($column[$ckey]) || $column[$ckey] < $length) {
                    $column[$ckey] = $length;
                }
            }
        }
 
        $table = '';
        foreach ($data as $rkey => $row) {
            foreach ($row as $ckey => $cell) {
                $table .= str_replace(PHP_EOL, '', str_pad($cell, $column[$ckey])) . '   ';
            }

            $table .= PHP_EOL;
        }

        return $table;
    }

    /**
     * @param string $header
     */
    public function header(string $header)
    {
        $this->output[] = [
            $this->warning($header, true)
        ];
    }

    /**
     * @param string $command
     * @param string $description
     */
    public function body(string $command, string $description)
    {
        $this->output[] = [
            $this->success('  ' . $command),
            $this->output(' ' . $description)
        ];
    }

    /**
     * @param string $group
     */
    public function group(string $group)
    {
        $this->output[] = [
            $this->warning(' ' . $group)
        ];
    }

    /**
     * @return void
     */
    public function display()
    {
        return $this->table($this->output);
    }

    /**
     * @return void
     */
    public function octopy()
    {
        echo exec('clear');

        $octopy[] = "   ___       _                     ";
        $octopy[] = "  / _ \  ___| |_ ___  _ __  _   _  ";
        $octopy[] = " | | | |/ __| __/ _ \| '_ \| | | | ";
        $octopy[] = " | |_| | (__| || (_) | |_) | |_| | ";
        $octopy[] = "  \___/ \___|\__\___/| .__/ \__, | ";
        $octopy[] = "   2018 - octopy.xyz |_|    |___/  ";
        $octopy[] = "";

        $output  = $this->output('%y%' . implode(PHP_EOL, $octopy), true);
        $output .= $this->output('%S% USAGE :%w% command [options] [args]') . PHP_EOL;
        return $output;
    }
}
