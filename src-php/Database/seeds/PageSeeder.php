<?php

namespace Dewsign\NovaPages\Database\Seeds;

use Illuminate\Database\Seeder;
use Dewsign\NovaPages\Models\Page;
use Dewsign\NovaRepeaterBlocks\Models\Repeater;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\AvailableBlocks;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\TextBlock;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(config('novapages.models.page', Page::class), 100)->create()->each(function ($page) {
            $page->repeaters()->saveMany(factory(Repeater::class, rand(0, 5))->create()->each(function ($repeater) {
                $repeater->type()->associate(factory(AvailableBlocks::random()::$model)->create())->save();
            }));
        });

        config('novapages.models.page', Page::class)::inRandomOrder()->take(rand(25, 75))->get()->each(function ($page) {
            $page->parent()->associate(config('novapages.models.page', Page::class)::inRandomOrder()->where('id', '<>', $page->id)->first());
            $page->save();
        });
    }
}
