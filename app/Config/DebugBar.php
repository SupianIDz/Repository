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

return [
   
   /*
     |--------------------------------------------------------------------------
     | Debugbar Theme
     |--------------------------------------------------------------------------
     |
     | This section you can choose theme for Octopy Debugbar if theme section
     | is empty, light theme displayed as default.
     | - dark
     | - light
     |
     */
    'theme' => 'dark',

    /*
     |--------------------------------------------------------------------------
     | DataCollector
     |--------------------------------------------------------------------------
     |
     | Enable or disable DataCollector
     |
     */
    'collector' => [
        'file'      => true, // Display All Loaded File
        'view'      => true, // Display Template Rendered
        'request'   => true, // Request Logger
        'route'     => true, // Current Route Information
        'query'     => true, // Show Database Queries
        'session'   => true, // Display Session Data
        'exception' => true, // Exception Displayer
        'memory'    => true, // Memory Usage
        'phpinfo'   => true, // PHP Version
        'time'      => true, // Time Datalogger
        'history'   => true, // Display Histories
    ],

    /*
     |--------------------------------------------------------------------------
     | Storage Settings
     |--------------------------------------------------------------------------
     |
     | DebugBar stores data for session/ajax requests.
     | You can disable this, so the debugbar stores data in headers/session,
     | but this can cause problems with large data collectors.
     |
     */
    'storage' => storage('framework.debugbar')
];
