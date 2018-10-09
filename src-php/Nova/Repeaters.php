<?php

namespace Dewsign\NovaPages\Nova;

use Illuminate\Http\Request;
use Dewsign\NovaPages\Nova\Page;
use Dewsign\NovaRepeaterBlocks\Fields\Repeater;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\TextBlock;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\TextareaBlock;

class Repeaters extends Repeater
{
    // One or more Nova Resources which use this Repeater
    public static $morphTo = [
        Page::class,
    ];

    // What type of repeater blocks should be made available
    public function types(Request $request)
    {
        return [
            TextBlock::class,
            TextareaBlock::class,
        ];
    }
}
