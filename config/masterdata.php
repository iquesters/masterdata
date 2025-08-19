<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Masterdata Route Middleware
    |--------------------------------------------------------------------------
    |
    | Here you can define which middleware should be applied to the package
    | routes. By default, only "web" middleware is applied, so routes are
    | accessible without authentication.
    |
    | If you want to protect routes, just add "auth" here:
    | ['web', 'auth']
    |
    */

    'middleware' => ['auth'],

    /*
    |--------------------------------------------------------------------------
    | Layout Configuration
    |--------------------------------------------------------------------------
    |
    | Specify the base layout that should be used for package views.
    | Default: Uses the package's built-in layout (masterdata::layouts.package)
    |
    | Options:
    | - 'masterdata::layouts.package' (default package layout)
    | - 'layouts.app' (use your application's layout)
    | - 'admin.layouts.master' (custom layout path)
    |
    */
    'layout' => env('MASTERDATA_LAYOUT', 'masterdata::layouts.package')
];