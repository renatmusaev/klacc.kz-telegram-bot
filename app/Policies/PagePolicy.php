<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class PagePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function viewAny($user)
    {
        return Gate::any(['viewPage', 'managePage'], $user);
    }
    
    public function view($user, $post)
    {
        return Gate::any(['viewPage', 'managePage'], $user, $post);
    }
    
    public function create($user)
    {
        return $user->can('managePage');
    }
    
    public function update($user, $post)
    {
        return $user->can('managePage', $post);
    }
    
    public function delete($user, $post)
    {
        return $user->can('managePage', $post);
    }
    
    public function restore($user, $post)
    {
        return $user->can('managePage', $post);
    }
    
    public function forceDelete($user, $post)
    {
        return $user->can('managePage', $post);
    }
}
