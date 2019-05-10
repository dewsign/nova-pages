<?php

namespace Dewsign\NovaPages;

use Dewsign\NovaPages\Models\Page;
use Illuminate\Support\Facades\File;

class NovaPages
{
    public static function sitemap($sitemap)
    {
        app(config('novapages.models.page', Page::class))::active()->get()->map(function ($item) use ($sitemap) {
            $sitemap->add(url($item->mapped_url));
        });
    }

    public static function availableTemplates()
    {
        $packageTemplatePath = __DIR__ . '/Resources/views/templates';
        $appTemplatePath = resource_path() . '/views/vendor/nova-pages/templates';

        $packageTemplates = File::exists($packageTemplatePath) ? File::files($packageTemplatePath) : null;
        $appTemplates = File::exists($appTemplatePath) ? File::files($appTemplatePath) : null;

        return collect($packageTemplates)->merge($appTemplates)->mapWithKeys(function ($file) {
            $filename = $file->getFilename();

            return [
                str_replace('.blade.php', '', $filename) => static::getPrettyFilename($filename),
            ];
        })->all();
    }

    private static function getPrettyFilename($filename)
    {
        $basename = str_replace('.blade.php', '', $filename);

        return title_case(str_replace('-', ' ', $basename));
    }
}
