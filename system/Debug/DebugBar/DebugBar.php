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

use Octopy\Container;
use Octopy\Support\Route;
use Octopy\Support\Session;

class DebugBar
{
    /**
     * @var object
     */
    private $config;

    /**
     * @var array
     */
    private $collector = [];

    /**
     * @var string
     */
    private $json;
    
    /**
     *
     */
    public function __construct()
    {
        $this->config = config('debugbar');
        
        if (config('app.debug')) {
            $this->json  = $this->config->storage;
            $this->json .= str_replace('.', '', OCTOPY_START_TIME);
            $this->json .= md5(OCTOPY_START_TIME) . '.json';
            
            $this->collector = [
                'file'      => new DebugBar\Collector\FileCollector,
                'view'      => new DebugBar\Collector\ViewCollector,
                'query'     => new DebugBar\Collector\QueryCollector,
                'route'     => new DebugBar\Collector\RouteCollector,
                'history'   => new DebugBar\Collector\HistoryCollector,
                'request'   => new DebugBar\Collector\RequestCollector,
                'session'   => new DebugBar\Collector\SessionCollector,
                'exception' => new DebugBar\Collector\ExceptionCollector,
            ];

            foreach ($this->collector as $name => $collector) {
                if ($name === 'history') {
                    continue;
                }
                
                $data[$name] = $collector->collect();
            }

            $this->collect($data);
        }
    }

    /**
     * @return string
     */
    public function inject()
    {
        if (config('app.debug')) {
            Session::set('OCTOPY_DEBUGBAR', file_get_contents($this->json));

            return PHP_EOL . view('DebugBar', [
                'config'    => $this->config,
                'collector' => $this->collector
            ]);
        }
    }

    /**
     * @param  array $data
     * @param  array $config
     * @return void
     */
    public function collect(array $data) : DebugBar
    {
        if (config('app.debug')) {
            if (!is_dir($this->config->storage)) {
                mkdir($this->config->storage, 0755, true);
            }

            $datetime = date('d-m-Y H:i:s', OCTOPY_START_TIME);

            if (!file_exists($this->json)) {
                $data = array_merge(['datetime' => $datetime], $data);
            } else {
                $data = array_merge_recursive($data, json_decode(file_get_contents($this->json), true));
            }

            file_put_contents($this->json, json_encode($data, JSON_UNESCAPED_SLASHES));
        }

        return $this;
    }
}
