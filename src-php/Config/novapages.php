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
        'disabled' => false,
        'field' => 'Laravel\Nova\Fields\Image',
        'disk' => 'public',
    ],
    'domainMap' => [],
    'rootDomain' => env('ROOT_DOMAIN', config('session.domain')),
    'enableLanguageSelection' => false,
    'defaultLanguage' => [
        'en-GB' => 'English'
    ],
    'languages' => [
        'de' => 'German',
        'nl' => 'Dutch',
        'fr' => 'French',
        'it' => 'Italian',
        'es' => 'Spanish'
    ]
];
