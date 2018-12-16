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

use Exception;

class Syntax
{
    /**
     * @var int
     */
    private $prev;
    
    /**
     * @var int
     */
    private $rnow;
        
    /**
     * @var int
     */
    private $next;

    /**
     * @var array
     */
    private $style = [
        '#BE5046' => [T_OPEN_TAG],
        '#818896' => [T_DOC_COMMENT],
        '#E6C07B' => [T_STRING],
        '#E06C75' => [T_VARIABLE],
        '#61AEEE' => [T_ARRAY],
        '#ABB2BF' => [T_DOUBLE_COLON, T_NS_SEPARATOR, T_IS_IDENTICAL, T_IS_NOT_IDENTICAL, T_IS_NOT_EQUAL],
        '#98C379' => [T_STRING, T_CONSTANT_ENCAPSED_STRING],
        '#C678DD' => [
            T_NEW,
            T_TRY,
            T_CATCH,
            T_CLASS,
            T_NAMESPACE,
            T_USE,
            T_STATIC,
            T_PUBLIC,
            T_PRIVATE,
            T_PROTECTED,
            T_FUNCTION,
            T_RETURN,
            T_IMPLEMENTS,
            T_EXTENDS,
            T_IF,
            T_REQUIRE,
            T_REQUIRE_ONCE,
            T_INCLUDE,
            T_INCLUDE_ONCE,
            T_FINAL,
            T_ABSTRACT,
            T_INTERFACE,
            T_THROW
        ]
    ];

    public function offset(int $start = 0, int $end = null)
    {
        $this->offset[0] = $start;
        
        if ($end) {
            $this->offset[1] = $end;
        }

        return $this;
    }

    public function highlight(string $source, int $highlighted = null)
    {
        if (is_file($source) && is_readable($source)) {
            try {
                $source = file_get_contents($source);
            } catch (Exception $e) {
                throw new Exception;
            }
        }

        $this->token = token_get_all($source);

        $source = '';

        foreach ($this->token as $i => $token) {
            $this->state($i);

            if (is_array($token)) {
                if ($this->rnow === T_WHITESPACE) {
                    $source .= $token[1];
                    continue;
                }

                if ($this->rnow === T_DOC_COMMENT) {
                    $docs = [];
                    foreach (explode("\n", $token[1]) as $doc) {
                        $docs[] = $this->span($doc);
                    }

                    $source .= $this->span(implode("\n", $docs));
                    continue;
                }

                if ($this->rnow === T_OPEN_TAG) {
                    $token[1] = htmlentities($token[1]);
                }

                $source .= $this->span($token[1]);
                continue;
            }

            $source .= $this->span($token);
        }

        $lines = explode("\n", $source);

        $length = strlen(count($lines));

        $source = '';

        foreach ($lines as $no => $line) {
            $no++;
            $space = '';

            if (isset($this->offset[0]) && $no < $this->offset[0]) {
                continue;
            }

            if (isset($this->offset[1]) && $no - 1 == $this->offset[1]) {
                break;
            }

            for ($i = 0; $i < $length - strlen($no); $i++) {
                $space .= ' ';
            }

            if ($highlighted !== null && $no === $highlighted) {
                $source .= '<span style="padding:2px;line-height:1.4;display:block;background:#555;color:#FFF;">';
                $source .= '<span style="color:#FFF;">' . $no . '</span>';
                $source .= $space . ' ' . $line;
                $source .= '</span>';
            } else {
                $source .= '<span style="padding:2px;line-height:1.4;">';
                $source .= '<span style="color:#666;">' . $no . '</span>';
                $source .= $space . ' ' . $line;
                $source .= '</span>';
                $source .= "\n";
            }
        }

        return '<pre style="background:#0c1021;padding:0.5em 1em;border-radius:5px;font-family:\'Roboto Mono\';font-size:13px;"><code>' . trim($source) . '</code><pre>';
    }

    /**
     * @param  string $code
     * @return string
     */
    private function span(string $code)
    {
        return '<span style="color:' . $this->color($code) . ';">' . $code . '</span>';
    }

    /**
     * @param  string $code
     * @return string
     */
    private function color(string $code) : string
    {
        if (defined($code)) {
            return '#D19A66';
        }

        if (function_exists($code) || in_array($code, ['foreach', 'isset'])) {
            return '#61AEEE';
        }

        if ($this->rnow == T_STRING && $this->next === '(') {
            return '#61AEEE';
        }

        if ($this->rnow == T_STRING && $this->prev === '->') {
            return '#E06C75';
        }

        foreach ($this->style as $hex => $token) {
            if (in_array($this->rnow, $token)) {
                return $hex;
            }
        }

        return '#ABB2BF';
    }

    /**
     * @param int $position
     */
    private function state(int $position)
    {
        $this->rnow = $this->token[$position][0] ?? $this->token[$position];
        
        if ($position > 0) {
            $position--;
        }

        $this->prev = $this->token[$position][0] ?? $this->token[$position];

        $position += 2;

        if ($position < count($this->token)) {
            $this->next = $this->token[$position][0] ?? $this->token[$position];
        }
    }
}
