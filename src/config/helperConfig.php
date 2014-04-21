<?php return [

    /*
    |--------------------------------------------------------------------------
    | What model type to use
    |--------------------------------------------------------------------------
    |
    | Setting this will override the default model system to use.
    |
    */

    'model_system' => 'laravel',

    /*
    |--------------------------------------------------------------------------
    | What database to connect to if there is no model found
    |--------------------------------------------------------------------------
    |
    | Sets the database connection to use to find the table fields for the
    | given model name.
    |
    */

    'database' => [

        'mysql' => [

            'host' => '192.168.2.10',
            'user' => 'root',
            'password' => 'telecom1',
            'database' => 'shared_components',

        ],

    ]

];