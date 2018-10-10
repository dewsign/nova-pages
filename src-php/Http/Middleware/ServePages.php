<?php

namespace Dewsign\NovaPages\Http\Middleware;

use Laravel\Nova\Nova;
use Dewsign\NovaPages\Events\NovaPagesProviderRegistered;

class ServePages
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        NovaPagesProviderRegistered::dispatch();

        return $next($request);
    }
}
