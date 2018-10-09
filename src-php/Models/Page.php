<?php

namespace Dewsign\NovaPages\Models;

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

class Page extends Model
{
    use HasSlug;
    use HasParent;
    use CanBeFeatured;
    use HasActiveState;
    use HasMetaAttributes;
    use HasRepeaterBlocks;
    use MustHaveCanonical;
    use WithPrioritisation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'active',
        'featured',
        'image',
        'name',
        'parent_id',
        'slug',
        'summary',
        'priority',
    ];

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
            "width" => 800,
            "height" => 450,
            "crop" => "fill",
            "gravity" => "auto",
            "fetch_format" => "auto",
        ]);
    }

    public function baseCanonical()
    {
        return request()->url();
    }
}
