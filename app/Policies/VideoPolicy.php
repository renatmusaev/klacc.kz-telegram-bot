<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class VideoPolicy
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
        return Gate::any(['viewVideo', 'manageVideo'], $user);
    }
    
    public function view($user, $post)
    {
        return Gate::any(['viewVideo', 'manageVideo'], $user, $post);
    }
    
    public function create($user)
    {
        return $user->can('manageVideo');
    }
    
    public function update($user, $post)
    {
        return $user->can('manageVideo', $post);
    }
    
    public function delete($user, $post)
    {
        return $user->can('manageVideo', $post);
    }
    
    public function restore($user, $post)
    {
        return $user->can('manageVideo', $post);
    }
    
    public function forceDelete($user, $post)
    {
        return $user->can('manageVideo', $post);
    }
}
