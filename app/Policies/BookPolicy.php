<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class BookPolicy
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
        return Gate::any(['viewBook', 'manageBook'], $user);
    }
    
    public function view($user, $post)
    {
        return Gate::any(['viewBook', 'manageBook'], $user, $post);
    }
    
    public function create($user)
    {
        return $user->can('manageBook');
    }
    
    public function update($user, $post)
    {
        return $user->can('manageBook', $post);
    }
    
    public function delete($user, $post)
    {
        return $user->can('manageBook', $post);
    }
    
    public function restore($user, $post)
    {
        return $user->can('manageBook', $post);
    }
    
    public function forceDelete($user, $post)
    {
        return $user->can('manageBook', $post);
    }
}
