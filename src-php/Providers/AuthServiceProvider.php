<?php

namespace Dewsign\NovaPages\Providers;

use Dewsign\NovaPages\Models\Page;
use Illuminate\Support\Facades\Gate;
use Dewsign\NovaPages\Policies\PagePolicy;
use Silvanite\Brandenburg\Traits\ValidatesPermissions;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    use ValidatesPermissions;

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Page::class => PagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        collect([
            'viewPage',
            'managePage',
        ])->each(function ($permission) {
            Gate::define($permission, function ($user) use ($permission) {
                if ($this->nobodyHasAccess($permission)) {
                    return true;
                }

                return $user->hasRoleWithPermission($permission);
            });
        });

        $this->registerPolicies();
    }
}
