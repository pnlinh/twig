<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Twig File Extension
    |--------------------------------------------------------------------------
    |
    | This option determines extension of twig file. Default is .html
    |
    */

    'extension' => 'html',

    /*
    |--------------------------------------------------------------------------
    | Twig Extensions
    |--------------------------------------------------------------------------
    |
    | Built-in extensions.
    |
    */
    'extensions' => [
        \Qh\Twig\Extensions\UrlExtension::class,
        \Qh\Twig\Extensions\CollectionExtension::class,
        \Qh\Twig\Extensions\StringExtension::class,
        \Qh\Twig\Extensions\UrlExtension::class,
        \Qh\Twig\Extensions\ConfigExtension::class,
        \Qh\Twig\Extensions\RequestExtension::class,
        \Qh\Twig\Extensions\AuthExtension::class,
        \Qh\Twig\Extensions\TranslationExtension::class,
        \Qh\Twig\Extensions\AuthorizationExtension::class,
        \Qh\Twig\Extensions\DebugExtension::class,

        // Add your extensions here...
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Twig templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => storage_path('framework/views/twig'),
];
