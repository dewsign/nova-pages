<?php

namespace Dewsign\NovaPages\Http\Controllers;

use Dewsign\NovaPages\Models\Page;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PageController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function show(string $domain = null, string $path = null)
    {
        $page = app(config('novapages.models.page', Page::class))::withParent()
            ->whereFullPath($path)
            ->first();

        if (!$page) {
            abort(404, __('Page not found"'));
        }

        return View::first([
            $page->template ? "nova-pages::templates.{$page->template}" : null,
            'nova-pages::show',
        ])
        ->with('page', $page);
    }
}
