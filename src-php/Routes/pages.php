<?php

$nova_url = ltrim(config('nova.path'), '/');

Route::get('{path?}', 'PageController@show')
    ->name('pages.show')
    ->where(['path' => '^(?!' . $nova_url  . '|nova-api|nova-vendor).*'])
    ->defaults('domain', '')
    ->defaults('path', config('novapages.homepageSlug', 'homepage'));
