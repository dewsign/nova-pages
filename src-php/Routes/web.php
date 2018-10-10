<?php

/**
 * Page Routes. Should be the last route as it doesn't have a root namespace and could take-over other routes
 */
Route::name('pages.')->group(function () {
    $nova_url = ltrim(config('nova.path'), '/');

    Route::get('{path}', 'PageController@show')
        ->name('show')
        ->where(['path' => '^(?!' . $nova_url  . '|nova-api|nova-vendor).*'])
        ->defaults('path', '');
});
