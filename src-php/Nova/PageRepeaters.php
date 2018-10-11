<?php

namespace Dewsign\NovaPages\Nova;

use Illuminate\Http\Request;
use Dewsign\NovaPages\Nova\Page;
use Dewsign\NovaRepeaterBlocks\Fields\Repeater;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\TextBlock;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\TextareaBlock;

class PageRepeaters extends Repeater
{
    // One or more Nova Resources which use this Repeater
    public static $morphTo = [
        Page::class,
    ];

    // What type of repeater blocks should be made available
    public function types(Request $request)
    {
        if (config('novapages.replaceRepeaters', false)) {
            return config('novapages.repeaters');
        }

        return array_merge([
            TextBlock::class,
            TextareaBlock::class,
        ], config('novapages.repeaters'));
    }
}