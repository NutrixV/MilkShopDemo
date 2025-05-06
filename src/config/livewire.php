<?php

$asset_url = env('URL', env('APP_URL', null));

return [

    /*
    |--------------------------------------------------------------------------
    | Asset URL (for .js and .css)
    |--------------------------------------------------------------------------
    |
    | This allows you to specify the base URL from which Livewire will load
    | its frontend resources (JS/CSS). For Render, a full HTTPS URL is required.
    |
    */

    'asset_url' => $asset_url . '/vendor/livewire/livewire.min.js',

    /*
    |--------------------------------------------------------------------------
    | JavaScript endpoint URL
    |--------------------------------------------------------------------------
    |
    | This is used to build the route to livewire.min.js
    | If not specified, asset_url or APP_URL is used.
    |
    */

    'url' => env('LIVEWIRE_URL', env('APP_URL', null)),

    /*
    |--------------------------------------------------------------------------
    | Livewire DOM Element Updater
    |--------------------------------------------------------------------------
    |
    | Options: 'poll', 'sync', 'dirty', 'lazy'
    |
    */

    'dom' => [
        'update' => 'sync',
    ],

    /*
    |--------------------------------------------------------------------------
    | Navigate: Progress Bar
    |--------------------------------------------------------------------------
    |
    */

    'navigate' => [
        'show_progress_bar' => true,
        'progress_bar_color' => '#2299dd',
    ],

];
