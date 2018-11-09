<?php
namespace Dewsign\NovaPages\Nova;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool as NovaTool;
use Dewsign\NovaPages\Nova\Page;

class NovaPagesTool extends NovaTool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::resources([
            config('novapages.resources.page', Page::class),
        ]);
    }
}
