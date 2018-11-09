<?php

return [
    'repeaters' => [],
    'replaceRepeaters' => false,
    'homepageSlug' => 'homepage',
    'models' => [
        'page' => 'Dewsign\NovaPages\Models\Page',
    ],
    'resources' => [
        'page' => 'Dewsign\NovaPages\Nova\Page',
    ],
    'group' => 'Pages',
    'images' => [
        'field' => 'Laravel\Nova\Fields\Image',
        'disk' => 'public',
    ],
    'domainMap' => [],
    'rootDomain' => config('session.domain'),
];
