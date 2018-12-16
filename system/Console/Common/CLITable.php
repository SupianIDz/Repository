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

namespace Octopy\Console\Common;

use Closure;

class CLITable
{

    /**
     * Table Data
     *
     * @var    object
     * @access protected
     *
     **/
    protected $data = null;

    /**
     * @var string
     **/
    protected $item = 'Row';

    /**
     * @var array
     **/
    protected $fields = [];

    /**
     * @var bool
     **/
    protected $headers = true;

    /**
     * @var bool
     **/
    protected $color = true;

    /**
     * @var string
     **/
    protected $tcolor = 'reset';

    /**
     * @var string
     **/
    protected $hcolor = 'reset';

    /**
     * @var array
     **/
    protected $colors = [];

    /**
     * @var array
     **/
    protected $chars = array(
        'top'          => '═',
        'top-mid'      => '╤',
        'top-left'     => '╔',
        'top-right'    => '╗',
        'bottom'       => '═',
        'bottom-mid'   => '╧',
        'bottom-left'  => '╚',
        'bottom-right' => '╝',
        'left'         => '║',
        'left-mid'     => '╟',
        'mid'          => '─',
        'mid-mid'      => '┼',
        'right'        => '║',
        'right-mid'    => '╢',
        'middle'       => '│ ',
    );


    /**
     * Constructor
     *
     * @access public
     * @param  string $item
     * @param  bool   $color
     */
    public function __construct($item = 'Row', $color = true)
    {
        $this->name($item);
        $this->color($color);
        $this->define();
    }

    /**
    * @param  bool $color
    * @return string
    */
    public function color(bool $use = null)
    {
        if ($use === null) {
            return $this->color;
        }

        $this->color = (bool) $use;
    }

    /**
     * @param  string $color
     * @return string
     */
    public function tcolor(string $color = null)
    {
        if ($color === null) {
            return $this->tcolor;
        }

        $this->tcolor = $color;
    }


    /**
     * @param  array $chars
     * @return void
     */
    public function schar($chars)
    {
        $this->chars = $chars;
    }

    /**
     * @param  string $color
     * @return string
     */
    public function hcolor(string $color = null)
    {
        if ($color === null) {
            return $this->hcolor;
        }

        $this->hcolor = $color;
    }

    /**
     * name
     *
     * @access public
     * @return string
     */
    public function name(string $name = null)
    {
        if ($name == null) {
            return $this->item;
        }

        $this->item = $name;
    }


    /**
     * injectData
     *
     * @access public
     * @param  array  $data
     * @return void
     */
    public function data($data)
    {
        $this->data = $data;
    }

    /**
     * @return bool
     */
    public function headers(bool $show = null) : bool
    {
        if ($show === null) {
            return $this->headers;
        }

        $this->headers = $bool;
    }

    /**
     * @param  string $name
     * @param  string $key
     * @param  string $color
     * @return void
     */
    public function add($name, $key, $color = 'reset') : void
    {
        $this->fields[$key] = array(
            'name'        => $name,
            'key'         => $key,
            'color'       => $color,
        );
    }


    /**
     * @return string
     */
    public function get() : string
    {
        $count   = 0;
        $length  = [];
        $headers = [];
        $cells   = [];

        if ($this->headers()) {
            foreach ($this->fields as $field) {
                $headers[$field['key']] = trim($field['name']);

                if (!isset($length[$field['key']])) {
                    $length[$field['key']] = 0;
                }

                $length[$field['key']] = max($length[$field['key']], strlen(trim($field['name'])));
            }
        }

        if ($this->data !== null) {
            if (count($this->data)) {
                foreach ($this->data as $row) {
                    $cells[$count] = [];
                    foreach ($this->fields as $field) {
                        $key   = $field['key'];
                        $value = $row[$key];

                        if ($key == 'middleware') {
                            foreach ($value as $i => $val) {
                                if ($val instanceof Closure) {
                                    $value[$i] = 'Closure';
                                }
                            }

                            $value = implode(', ', $value);
                        }

                        if ($value instanceof Closure) {
                            $value = 'Closure';
                        } elseif (is_array($value)) {
                            $value = implode('|', $value);
                        }

                        $cells[$count][$key] = $value;

                        if (!isset($length[$key])) {
                            $length[$key] = 0;
                        }

                        $length[$key] = max($length[$key], strlen($value));
                    }
                    $count++;
                }
            }
        }

        $response = '';
        $response .= $this->top($length);
        if ($this->headers()) {
            $response .= $this->row($headers, $length, true);
            $response .= $this->separator($length);
        }

        foreach ($cells as $row) {
            $response .= $this->row($row, $length);
        }

        $response .= $this->bottom($length);

        return $response;
    }


    /**
     * @param  array  $data
     * @param  array  $length
     * @param  bool   $header
     * @return string
     */
    protected function row(array $data, array $length, bool $header = false) : string
    {
        $response = $this->char('left');

        foreach ($data as $key => $field) {
            if ($header) {
                $color = $this->hcolor();
            } else {
                $color = $this->fields[$key]['color'];
            }

            $flen      = strlen($field) + 1;
            $field     = ' ' . ($this->color() ? $this->colorname($color) : '') . $field;
            $response .= $field;

            for ($x = $flen; $x < ($length[$key] + 2); $x++) {
                $response .= ' ';
            }

            $response .= $this->char('middle');
        }

        return substr($response, 0, strlen($response) - 3) . $this->char('right') . PHP_EOL;
    }


    /**
     * @param  array  $length
     * @return string
     */
    protected function top(array $length)
    {
        $response = $this->char('top-left');
        foreach ($length as $length) {
            $response .= $this->char('top', $length + 2);
            $response .= $this->char('top-mid');
        }

        return substr($response, 0, strlen($response) - 3) . $this->char('top-right') . PHP_EOL;
    }


    /**
     * @param  array  $length
     * @return string
     */
    protected function bottom(array $length) : string
    {
        $response = $this->char('bottom-left');
        foreach ($length as $length) {
            $response .= $this->char('bottom', $length + 2);
            $response .= $this->char('bottom-mid');
        }

        return substr($response, 0, strlen($response) - 3) . $this->char('bottom-right') . PHP_EOL;
    }


    /**
     * @param  array  $length
     * @return string
     */
    protected function separator($length) : string
    {
        $response = $this->char('left-mid');
        foreach ($length as $length) {
            $response .= $this->char('mid', $length + 2);
            $response .= $this->char('mid-mid');
        }
        
        return substr($response, 0, strlen($response) - 3) . $this->char('right-mid') . PHP_EOL;
    }


    /**
     * @param  string $type
     * @param  int    $length
     * @return string
     */
    protected function char(string $type, int $length = 1) : string
    {
        $response = '';
        if (isset($this->chars[$type])) {
            if ($this->color()) {
                $response .= $this->colorname($this->tcolor());
            }
            $char = trim($this->chars[$type]);
            for ($x = 0; $x < $length; $x++) {
                $response .= $char;
            }
        }

        return $response;
    }


    /**
     * @return void
     */
    protected function define()
    {
        $this->colors = array(
            'blue'    => chr(27).'[1;34m',
            'red'     => chr(27).'[1;31m',
            'green'   => chr(27).'[1;32m',
            'yellow'  => chr(27).'[1;33m',
            'black'   => chr(27).'[1;30m',
            'magenta' => chr(27).'[1;35m',
            'cyan'    => chr(27).'[1;36m',
            'white'   => chr(27).'[1;37m',
            'grey'    => chr(27).'[0;37m',
            'reset'   => chr(27).'[0m',
        );
    }


    /**
     * @param  string $name
     * @return string
     */
    protected function colorname(string $name = null)
    {
        if (isset($this->colors[$name])) {
            return $this->colors[$name];
        }

        return $this->colors['reset'];
    }


    /**
     * @return void
     */
    public function display()
    {
        print $this->get();
    }
}
