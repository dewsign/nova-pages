<?php

namespace Dewsign\NovaPages\Policies;

use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    public function viewAny()
    {
        return Gate::any(['viewPage', 'managePage']);
    }

    public function view($model)
    {
        return Gate::any(['viewPage', 'managePage'], $model);
    }

    public function create($user)
    {
        return $user->can('managePage');
    }

    public function update($user, $model)
    {
        return $user->can('managePage', $model);
    }

    public function delete($user, $model)
    {
        return $user->can('managePage', $model);
    }

    public function restore($user, $model)
    {
        return $user->can('managePage', $model);
    }

    public function forceDelete($user, $model)
    {
        return $user->can('managePage', $model);
    }

    public function viewInactive($user = null, $page)
    {
        if (config('maxfactor-support.canViewInactive')) {
            return true;
        }

        if ($page->active) {
            return true;
        }

        if (Gate::allows('viewNova')) {
            return true;
        }

        return false;
    }
}
