<?php

namespace Dewsign\NovaPages\Nova;

use Illuminate\Http\Request;
use Dewsign\NovaPages\Nova\Page;
use Dewsign\NovaRepeaterBlocks\Fields\Repeater;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\CustomViewBlock;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\TextBlock;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\ImageBlock;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\TextareaBlock;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\MarkdownBlock;

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
            CustomViewBlock::class,
            ImageBlock::class,
            TextBlock::class,
            TextareaBlock::class,
            MarkdownBlock::class,
        ], config('novapages.repeaters'));
    }
}
