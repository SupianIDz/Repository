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

use Closure;

use Octopy\Engine;

class Compiler
{
    /**
     * @var string
     */
    const PATTERN = '/@(.*)|{{(.*?)}}/';

    /**
     *
     */
    public function __construct()
    {
        $this->directives = [
            new Compiler\PHPDirective,
            new Compiler\CSRFDirective,
            new Compiler\BlockDirective,
            new Compiler\StringDirective,
            new Compiler\ExtendDirective,
            new Compiler\ControlDirective,
            new Compiler\IncludeDirective,
            new Compiler\SectionDirective,
        ];
    }

    /**
     * @param  Engine  $engine
     * @param  Closure $fallback
     * @return string
     */
    public function compile(Engine $engine, Closure $fallback)
    {
        $tokenized = $this->tokenize($source = file_get_contents($engine->template));

        $isearch = $replace = [];

        foreach ($tokenized as $line) {
            if (in_array($line['value'], $isearch)) {
                continue;
            }

            if (!is_integer($line['token'])) {
                $isearch[] = $line['token'];
                $replace[] = $this->add('echo ' . $line['value']);
            } else {
                $stream = new Stream($line);
                foreach ($this->directives as $directive) {
                    if ($line['token'] === T_EXIT || $line['token'] === T_CONTINUE) {
                        $isearch[] = '@' . $line['value'];
                        $replace[] = $this->add($line['value']);
                        break;
                    }

                    if ($code = $directive->parse($stream, $engine)) {
                        $isearch[] = '@' . $line['value'];
                        $replace[] = $this->add($code);
                        break;
                    }
                }
            }
        }

        if ($fallback instanceof Closure) {
            $isearch = array_merge($isearch, [
                '@php', '@endphp'
            ]);
            
            $replace = array_merge($replace, [
                '<?php', '?>'
            ]);

            return call_user_func($fallback, str_replace($isearch, $replace, $source));
        }
    }

    /**
     * @param  string $source
     * @return array
     */
    private function tokenize(string $source) : array
    {
        preg_match_all(Compiler::PATTERN, $source, $matches);
        $result = [];
        
        foreach ($matches[0] as $i => $source) {
            $line = $matches[1][$i] !== '' ? $matches[1][$i] : $matches[2][$i];
            if ($matches[1][$i] !== '') {
                $array = preg_split('/@/', $line);
                foreach ($array as $val) {
                    if (!in_array($val, $result)) {
                        $tokenized = token_get_all('<?php ' . $val . ' ?>');
                        foreach ($tokenized as $token) {
                            if (is_array($token)) {
                                if (preg_match('/' . $token[1] . '/', $val)) {
                                    preg_match('/(.*)\)/', $val, $value);
                                    $result[] = [
                                        'token' => $token[0],
                                        'value' => strip_tags($value[0] ?? $val)
                                    ];
                                    break;
                                }
                            }
                        }
                    }
                }
            } elseif ($matches[2][$i] !== '') {
                $result[] = [
                    'token' => $source,
                    'value' => trim($line)
                ];
            }
        }

        return $result ?? [];
    }

    /**
     * @param string $code
     */
    private function add(string $code) : string
    {
        if (substr(trim($code), -1) !== ':') {
            $code .= ';';
        }

        return sprintf('<?php %s ?>', $code);
    }
}
