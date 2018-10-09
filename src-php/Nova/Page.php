<?php

namespace Dewsign\NovaPages\Nova;

use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\MorphMany;
use Dewsign\NovaPages\Nova\Repeaters;
use Naxon\NovaFieldSortable\Sortable;
use Benjaminhirsch\NovaSlugField\Slug;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Http\Requests\NovaRequest;
use Dewsign\NovaPages\Nova\Filters\PageType;
use Benjaminhirsch\NovaSlugField\TextWithSlug;
use Dewsign\NovaPages\Nova\Filters\ActiveState;
use Maxfactor\Support\Webpage\Nova\MetaAttributes;
use Silvanite\NovaFieldCloudinary\Fields\CloudinaryImage;

class Page extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Dewsign\NovaPages\Models\Page';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
        'summary',
    ];

    public static $group = 'Pages';

    public static function label()
    {
        return __('Pages');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Boolean::make('Active')->sortable()->rules('required', 'boolean'),
            Boolean::make('Featured')->sortable()->rules('required', 'boolean'),
            Number::make('Priority')->sortable()->rules('required', 'integer'),
            TextWithSlug::make('Name')->sortable()->rules('required_if:active,1', 'max:254')->slug('Slug'),
            Slug::make('Slug')->sortable()->rules('required', 'alpha_dash', 'max:254')->hideFromIndex(),
            BelongsTo::make('Parent', 'parent', Page::class),
            CloudinaryImage::make('Image'),
            Textarea::make('Summary'),
            HasMany::make('Child Pages', 'children', Page::class),
            MorphMany::make(__('Repeaters'), 'repeaters', Repeaters::class),
            MetaAttributes::make(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new ActiveState,
            new PageType,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
