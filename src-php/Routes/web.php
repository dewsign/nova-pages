<?php

/**
 * Page Routes. Should be the last route as it doesn't have a root namespace and could take-over other routes
 */
Route::domain('{domain}.' . config('novapages.rootDomain'))->name('domain.')->group(function () {
    include('pages.php');
});

include('pages.php');
