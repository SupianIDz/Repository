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
    | Compiled Static Cache
    |--------------------------------------------------------------------------
    |
    | This option specifies the result page of the compiled Octopy template
    | whose data is infrequent or unchanging, making the static cache
    | to save resources within the specified time the cache will be expired
    | and re-rendered again and stored in html form.
    |
    */
    'static' => [
        'enable'   => false,
        'lifetime' => 3600,
    ],

    /*
    |--------------------------------------------------------------------------
    | Output
    |--------------------------------------------------------------------------
    |
    | This option determines the html results from the template to be reduced
    | resource use or encoded into a javascript to hide the source code.
    |
    */
    'output' => [
        'minify'   => false,
        'encode'   => false, // Not good for SEO reasons
    ],

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Octopy view path has already been registered for you.
    |
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Octopy templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */
    'path' => [
        'resource'   => [
            app('View')
        ],
        'compiled' => storage('framework.views')
    ]
];
