<?php

namespace Dewsign\NovaPages\Http\Controllers;

use Dewsign\NovaPages\Models\Page;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PageController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * The main show route to display pages. This includes domain mapped pages and the homepage.
     * In general, this method could do with some cleaning up but everything works for now.
     *
     * If a domain mapped page is requested on a different domain it will automatically
     * be redirected to the correct domain name mapped path.
     *
     * @param string $domain
     * @param string $path
     * @return \Illuminate\View\View
     */
    public function show(string $domain = null, string $path = null)
    {
        if (!$path) {
            $path = $domain;
            $domain = null;
        }

        if ($domain && in_array($domain, config('novapages.domainMap'))) {
            $path = str_replace(config('novapages.models.page')::getHomepageSlug(), '', $path);
            /**
             * Since we are now mapping to domain names we actually need to reverse
             * the map in order to lookup the correct page with the full path.
             */
            $reverseMappedPath = collect([$domain, $path])->filter()->implode('/');
        }

        if ($desiredRoute = config('novapages.models.page', Page::class)::isWithinDomainMap($domain, $path)) {
            if ($desiredRoute !== URL::current()) {
                return Redirect::away($desiredRoute);
            }
        };

        $page = app(config('novapages.models.page', Page::class))::withParent()
            ->whereFullPath($reverseMappedPath ?? $path, $excludeMappedDomains = false)
            ->first();

        if (!$page) {
            abort(404, __('Page not found"'));
        }

        return View::first([
            $page->template ? "nova-pages::templates.{$page->template}" : null,
            'nova-pages::show',
        ])
        ->with('page', $page)
        ->whenActive($page);
    }
}
