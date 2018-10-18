<?php

namespace Dewsign\NovaPages\Models;

use ScoutElastic\Searchable;
use Maxfactor\Support\Webpage\Model;
use Illuminate\Support\Facades\Route;
use Maxfactor\Support\Webpage\Traits\HasSlug;
use Maxfactor\Support\Webpage\Traits\HasParent;
use Maxfactor\Support\Model\Traits\CanBeFeatured;
use Maxfactor\Support\Model\Traits\HasActiveState;
use Maxfactor\Support\Model\Traits\WithPrioritisation;
use Maxfactor\Support\Webpage\Traits\HasMetaAttributes;
use Maxfactor\Support\Webpage\Traits\MustHaveCanonical;
use Dewsign\NovaRepeaterBlocks\Traits\HasRepeaterBlocks;
use Dewsign\NovaPages\IndexConfigurators\PageIndexConfigurator;

class Page extends Model
{
    use HasSlug;
    use HasParent;
    use Searchable;
    use CanBeFeatured;
    use HasActiveState;
    use HasMetaAttributes;
    use HasRepeaterBlocks;
    use MustHaveCanonical;
    use WithPrioritisation;

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get a page's parent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Get a page's children.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id', 'id');
    }

    public function getFeaturedImageLargeAttribute()
    {
        if (!$this->image) {
            return null;
        }

        return cloudinary_image($this->image, [
            "width" => 1600,
            "height" => 900,
            "crop" => "fill",
            "gravity" => "auto",
            "fetch_format" => "auto",
        ]);
    }

    /**
     * Add required items to the breadcrumb seed
     *
     * @return array
     */
    public function seeds()
    {
        $trail = collect([]);

        $this->seedParent($trail, $this);

        return array_merge(parent::seeds(), $trail->all(), [
            [
                'name' => $this->navTitle,
                'url' => route('pages.show', [$this->full_url]),
            ],
        ]);
    }

    /**
     * Recursively add parent pages to the breadcrumb seed
     *
     * @param Illuminate\Support\Collection $seed
     * @param Dewsign\NovaPages\Models\Page $item
     * @return Illuminate\Support\Collection
     */
    private function seedParent(&$seed, $item)
    {
        if (!$parent = $item->parent) {
            return;
        }

        $this->seedParent($seed, $parent);

        $seed->push([
            'name' => $parent->h1,
            'url' => $parent->full_path,
        ]);
    }

    public function baseCanonical()
    {
        return request()->url();
    }
}
