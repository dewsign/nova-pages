<?php

namespace Dewsign\NovaPages\Http\Middleware;

class RedirectHomepageSlugToRoot
{
    /**
     * Ensure the homepage can not be accessed at multiple URLs
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        $homepageSlug = config('novapages.models.page')::getHomepageSlug();

        if ($homepageSlug && $request->is($homepageSlug)) {
            return redirect('/', 301);
        }

        return $next($request);
    }
}
