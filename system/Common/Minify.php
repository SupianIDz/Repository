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

namespace Octopy\Common;

class Minify
{
    /**
     * @param  string $source
     * @return string
     */
    public function encode(string $source)
    {
        $output  = '<!-- Octopy Framework -->' . PHP_EOL;
        $output .= '<script type="text/javascript">' . PHP_EOL;
        $output .= '   document.write(atob("' . base64_encode($source) . '"));' . PHP_EOL;
        $output .= '</script>' . PHP_EOL;
        $output .= '<noscript>Javascript Required</noscript>' . PHP_EOL;
        $output .= '<!-- Octopy Framework -->';
        return $output;
    }

    /**
     * @param  string $source
     * @param  array  $pattern
     * @return string
     */
    public function html(string $source, array $pattern = []) : string
    {
        $pattern = array_merge($pattern, [
            '/<style(.*)>/Uis'             => '<style>',
            '/<!--(.*)-->/Uis'             => '',
            '/[[:blank:]]+/'               => ' ',
            '/ type="text\/javascript"/'   => '',
            '/ type=\'text\/javascript\'/' => '',
        ]);

        return preg_replace(array_keys($pattern), $pattern, str_replace(["\n","\r","\t"], '', $source));
    }

    /**
     * @param  string $source
     * @param  array  $pattern
     * @return string
     */
    public function css(string $source, array $pattern = []) : string
    {
        return $source;
    }

    /**
     * @param  string $source
     * @param  array  $pattern
     * @return string
     */
    public function js(string $source, array $pattern = [])
    {
        return $source;
    }
}
