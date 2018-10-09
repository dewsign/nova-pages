<?php

namespace Dewsign\NovaPages\Tests;

use Dewsign\NovaPages\Models\Page;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class PageTest extends TestCase
{
    public function testRandomPageIsAccessible()
    {
        $result = $this->get(route('pages.show', [Page::active()->inRandomOrder()->first()]));
        $result->assertOk();
    }
}
