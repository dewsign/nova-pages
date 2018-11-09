<?php

namespace Dewsign\NovaPages\Tests;

use Dewsign\NovaPages\Models\Page;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class PageTest extends TestCase
{
    public function testRandomRootPageIsAccessible()
    {
        $result = $this->get(route('pages.show', [
            app(config('novapages.models.page', Page::class))::active()
                ->doesntHave('parent')
                ->inRandomOrder()
                ->first()
                ->full_path,
        ]));

        $result->assertOk();
    }

    public function testRandomChildPageIsAccessible()
    {
        $result = $this->get(route('pages.show', [
            app(config('novapages.models.page', Page::class))::active()
                ->has('parent')
                ->inRandomOrder()
                ->first()
                ->full_path,
        ]));

        $result->assertOk();
    }
}
