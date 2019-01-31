<?php

namespace Dewsign\NovaPages\Models;

use Maxfactor\Support\Webpage\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Builder;
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
    protected $guarded = [];

    protected $homepageSlug;

    public function __construct(array $attributes = [])
    {
        $this->domainMappedFolders = config('novapages.domainMap');
        $this->homepageSlug = config('novapages.homepageSlug', 'homepage');

        parent::__construct($attributes);
    }

    protected $domainMappedFolders = [];

    /**
     * Get a page's parent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(config('novapages.models.page', Page::class));
    }

    /**
     * Get a page's children.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(config('novapages.models.page', Page::class), 'parent_id', 'id');
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
                'name' => $this->h1,
                'url' => $this->full_path,
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
            'name' => $parent->navTitle,
            'url' => $parent->full_path,
        ]);
    }

    public function baseCanonical()
    {
        return $this->full_path;
    }

    /**
     * Return a page object to allow customising of meta fields for non-dynamic pages.
     * E.g. blog index page. Pass in a default string or array incase no matching page exists.
     *
     * @param string $slug
     * @param string|array $default
     * @return Collection|array
     */
    public static function meta(string $slug, $default = null)
    {
        if (!is_array($default)) {
            $default = [
                'page_title' => $default,
                'browser_title' => $default,
                'meta_description' => $default,
                'h1' => $default,
            ];
        }

        return self::withParent()->whereFullPath($slug)->first() ?? $default;
    }

    /**
     * Overload default method to exclude the homepage slug from the full path
     *
     * @return string Full path
     */
    public function getFullPathAttribute()
    {
        $pathSections = explode('/', $this->getFullPath());

        $slugsToExclude = array_merge(
            array_wrap($this->domainMappedFolders),
            array_wrap($this->homepageSlug)
        );

        $finalSlug = collect($pathSections)
            ->filter()
            ->reject(function ($slug) use ($slugsToExclude) {
                return in_array($slug, $slugsToExclude);
            })
            ->implode('/');

        return str_start($finalSlug, '/');
    }


    /**Overload scope to add additional cnditions for the homepage slug
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $path Full path
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereFullPath(Builder $query, string $path)
    {
        $itemSlugs = explode('/', $path);

        $slugsToExclude = array_wrap($this->homepageSlug);

        $finalSlug = collect($itemSlugs)
            ->filter()
            ->reject(function ($slug) use ($slugsToExclude) {
                return in_array($slug, $slugsToExclude);
            })
            ->implode('/');

        return $query->where('slug', '=', end($itemSlugs))
            ->get()
            ->filter(function ($item) use ($finalSlug) {
                return $item->full_path === str_start($finalSlug, '/');
            });
    }
}
