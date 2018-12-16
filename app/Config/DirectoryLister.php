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
    
    /**
     * Root path of directory lister
     */
    'root' => basepath('repository'),

    /**
     * Temp folder
     */
    'temporary' => storage('temporary'),
    
    /**
     * Excluded files or directories
     * Regex pattern only
     */
    'exclude' => [
        '/error_log/',
        '/(.*)\.(php|phtml|json|txt|htaccess|ini|env)/'
    ],
        
    /**
     *
     */
    'icon' => [
        'icon-pdf'     => ['pdf'],
        'icon-word'    => ['doc', 'docx'],
        'icon-ppt'     => ['ppt', 'pptx'],
        'icon-excel'   => [],
        'icon-image'   => ['png', 'jpg', 'jpeg', 'svg', 'psd', 'ico'],
        'icon-video'   => ['mp4', '3gp', 'mkv', 'flv'],
        'icon-music'   => ['mp3'],
        'icon-archive' => ['zip', 'gzip', 'bzip', '7zip', '7z', 'rar']
    ],
];
