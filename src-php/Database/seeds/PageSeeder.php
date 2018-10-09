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
        factory(Page::class, 100)->create()->each(function ($page) {
            $page->repeaters()->saveMany(factory(Repeater::class, rand(0, 5))->create()->each(function ($repeater) {
                $repeater->type()->associate(factory(AvailableBlocks::random())->create())->save();
            }));
        });

        Page::inRandomOrder()->take(rand(25, 75))->get()->each(function ($page) {
            $page->parent()->associate(Page::inRandomOrder()->where('id', '<>', $page->id)->first());
            $page->save();
        });
    }
}
