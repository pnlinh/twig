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
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Twig templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => realpath(storage_path('framework/views/twig')),
];