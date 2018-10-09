<?php

/**
 * Page Routes. Should be the last route as it doesn't have a root namespace and could take-over other routes
 */
Route::name('pages.')->group(function () {
    // Route::get('{path}', 'Dewsign\NovaPages\Http\Controllers\PageController@show')->name('show')->where(['path' => '.*']);
});
