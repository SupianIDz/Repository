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
namespace Octopy\Debug\DebugBar;

use Exception;

use Octopy\HTTP\Request;
use Octopy\Support\Session;
use Octopy\Support\Response;

class DebugBarController
{
    /**
     * @var string
     */
    private $storage;

    /**
     *
     */
    public function __construct()
    {
        $this->storage = config('debugbar.storage');
    }
    
    /**
     * @param  Request $request
     * @return string
     */
    public function load(Request $request)
    {
        $action = $request->__debugbar_action;
        if ($action === 'history') {
            $data = array_diff(scandir($this->storage), ['.', '..']);
            usort($data, function ($before, $after) {
                return filemtime($this->storage . $before) < filemtime($this->storage . $after);
            });
        } else {
            $data = json_decode(Session::get('OCTOPY_DEBUGBAR'));
        }

        if ($action == 'memory') {
            if ($data->memory < 1024) {
                return ' ' .$data->memory . 'B';
            } elseif ($data->memory < 1048576) {
                return ' ' . round($data->memory / 1024, 2) . 'KB';
            }

            return ' ' . round($data->memory / 1048576, 2) . 'MB';
        } elseif ($action == 'elapsed') {
            return ' ' . round($data->elapsed * 1000, 3) . 'ms';
        }

        return view('Child.' . ucwords($action), ['data' => $data]);
    }

    /**
     * @param  Request $request
     * @return string
     */
    public function reload(Request $request)
    {
        try {
            $data = file_get_contents($this->storage . $request->__debugbar_file);
            Session::set('OCTOPY_DEBUGBAR', $data);
        } catch (Exception $e) {
            throw new Exception;
        }
    }

    /**
     * @param  Request $request
     * @return string
     */
    public function delete(Request $request)
    {
        if ($request->__debugbar_file == 'all') {
            $scandir = scandir($this->storage);
            foreach ($scandir as $file) {
                if (is_file($this->storage . $file) && is_writable($this->storage . $file)) {
                    unlink($this->storage . $file);
                }
            }
        } else {
            if (file_exists($file = $this->storage . $request->__debugbar_file)) {
                unlink($file);
            }
        }
    }

    /**
     * @param  string $file
     * @return string
     */
    public function css(string $file)
    {
        try {
            $data = file_get_contents(octopy('Debug.Resource.CSS', $file . '.min.css'));

            return response()->header('Content-Type', 'text/css')->content($data);
        } catch (Exception $e) {
            return '';
        }
    }

    /**
     * @param  string $file
     * @return string
     */
    public function js(string $file)
    {
        try {
            $data = file_get_contents(octopy('Debug.Resource.JS', $file . '.min.js'));

            return response()->header('Content-Type', 'text/javascript')->content($data);
        } catch (Exception $e) {
            return '';
        }
    }

    /**
     * @param  string $file
     * @return string
     */
    public function font(string $file)
    {
        try {
            $data = file_get_contents(octopy('Debug.Resource.FONT', $file));
        
            return response()->header('Content-Type', 'application/font-woff')->content($data);
        } catch (Exception $e) {
            return '';
        }
    }
}
