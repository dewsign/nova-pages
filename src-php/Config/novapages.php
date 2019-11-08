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
    'rootDomain' => env('ROOT_DOMAIN', config('session.domain')),
    'enableLanguageSelection' => false,
    'defaultLanguage' => [
        'en' => 'english'
    ],
    'languages' => [
        'de' => 'german',
        'nl' => 'dutch',
        'fr' => 'french',
        'it' => 'italian'
    ]
];
