<?php

namespace Dewsign\NovaPages;

use Dewsign\NovaPages\Models\Page;

class NovaPages
{
    public static function sitemap($sitemap)
    {
        Page::active()->get()->map(function ($item) use ($sitemap) {
            $sitemap->add(route('pages.show', [$item->full_path]));
        });
    }
}
