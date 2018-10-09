<?php

namespace Dewsign\NovaPages\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class PageType extends Filter
{
    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        if ($value === 'root') {
            return $query->whereDoesntHave('parent');
        }

        if ($value === 'parent') {
            return $query->whereHas('children');
        }

        if ($value === 'child') {
            return $query->whereDoesntHave('children');
        }
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Root Pages' => 'root',
            'Parent Pages' => 'parent',
            'Final Child Pages' => 'child',
        ];
    }
}
