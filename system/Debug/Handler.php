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

namespace Octopy\Debug;

use Closure;
use stdClass;
use Throwable;
use Exception;
use ErrorException;

use Octopy\Support\Request;
use Octopy\Support\Response;
use Octopy\Support\DebugBar;

abstract class Handler
{
    /**
     *
     */
    public function __construct()
    {
        set_exception_handler([$this, 'handle']);

        set_error_handler([$this, 'error']);

        register_shutdown_function([$this, 'shutdown']);
    }

    /**
     * @param  string $method
     * @param  array  $parameter
     * @return string
     */
    public static function __callStatic(string $method, array $parameter = []) : string
    {
        if (strtolower($method) === 'render') {
            $array = explode(BS, get_class($parameter[1]));

            $code = abs($parameter[1]->getCode());
            if ($code < 100 || $code > 599) {
                $code = 500;
            }

            if ($parameter[0]->ajax()) {
                return response()->json([
                    'title'   => end($array),
                    'message' => $parameter[1]->getMessage()
                ], $code);
            }

            $template = PHP_SAPI === 'cli' ? 'CLI' : 'ErrorException';

            return view($template, [
                'code'      => $code,
                'title'     => end($array),
                'file'      => $parameter[1]->getFile(),
                'line'      => $parameter[1]->getLine(),
                'message'   => $parameter[1]->getMessage(),
                'trace'     => $parameter[1]->getTrace(),
            ]);
        }
    }

    /**
     * @param  Throwable $exception
     * @return mixed
     */
    public function handle(Throwable $exception)
    {
        $errcode = $this->code($exception);
        
        $this->logger($detail = [
            'title'   => get_class($exception),
            'code'    => $errcode,
            'file'    => $exception->getFile(),
            'line'    => $exception->getLine(),
            'trace'   => $exception->getTrace(),
            'message' => $exception->getMessage()
        ]);

        $response = $this->render($request = Request::instance(), $exception);

        if (config('app.debug') && PHP_SAPI !== 'cli') {
            if (!preg_match('/__octopy_debugbar/', $request->uri())) {
                DebugBar::collect([
                    'elapsed'   => microtime(true) - OCTOPY_START_TIME,
                    'memory'    => memory_get_usage(),
                    'exception' => $detail
                ]);
            }
        }

        die(Response::content($response ?? '')->code($errcode));
    }

    /**
     * @param  int    $severity
     * @param  string $message
     * @param  string $file
     * @param  int    $line
     */
    public function error(int $severity, string $message, string $file = null, int $line = null) : void
    {
        throw new ErrorException($message, 0, $severity, $file, $line);
    }

    /**
     * @return void
     */
    public function shutdown() : void
    {
        $error = error_get_last();

        if (!is_null($error) && in_array($error['type'], [E_PARSE, E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR])) {
            $this->handle(
                new ErrorException($error['message'], $error['type'], 0, $error['file'], $error['line'])
            );
        }
    }

    /**
     * @param  Throwable $exception
     * @return int
     */
    public function code(Throwable $exception) : int
    {
        $code = abs($exception->getCode());
        if ($code < 100 || $code > 599) {
            $code = 500;
        }

        return $code ?? 500;
    }

    /**
     * @param array $exception
     */
    public function logger(array $exception)
    {
        extract($exception);

        $location = str_replace(BASEPATH, '/', $file);

        $data  = 'Exception : ' . $title . PHP_EOL;
        $data .= 'Message   : ' . str_replace(BASEPATH, '/', $message !== '' ? $message : '-') . PHP_EOL;
        $data .= 'Location  : ' . $location . '#' . $line . PHP_EOL;
        $data .= 'Datetime  : ' . date('D, d-m-Y H:i:s') . PHP_EOL;
        $data .= '================================================' . PHP_EOL;
       
        if(!is_dir($storage = storage('framework'))) {
            mkdir($storage, 0755);
        }

        try {
            file_put_contents(storage('framework', 'octopy.log'), $data, FILE_APPEND);
        } catch (Exception $e) {
            throw new Exception;
        }
    }
}
