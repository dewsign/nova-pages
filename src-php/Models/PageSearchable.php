<?php

namespace Dewsign\NovaPages\Models;

use ScoutElastic\Searchable;
use Dewsign\NovaPages\Models\Page as BasePage;
use Dewsign\NovaPages\IndexConfigurators\PageIndexConfigurator;

class PageSearchable extends BasePage
{
    use Searchable;

    protected $indexConfigurator = PageIndexConfigurator::class;

    // Mapping for a model fields.
    protected $mapping = [
        'properties' => [
            'text' => [
                'type' => 'text',
                'fields' => [
                    'raw' => [
                        'type' => 'keyword',
                    ]
                ]
            ],
        ]
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $this->repeaters;

        $searchable = $this->toArray();

        $searchable = array_except($searchable, [
            'active',
            'browser_title',
            'h1',
            'meta_description',
            'nav_title',
            'canonical',
            'parent',
        ]);

        return $searchable;
    }
}
