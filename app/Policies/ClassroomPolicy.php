<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class ClassroomPolicy
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
        return Gate::any(['viewClassroom', 'manageClassroom'], $user);
    }
    
    public function view($user, $post)
    {
        return Gate::any(['viewClassroom', 'manageClassroom'], $user, $post);
    }
    
    public function create($user)
    {
        return $user->can('manageClassroom');
    }
    
    public function update($user, $post)
    {
        return $user->can('manageClassroom', $post);
    }
    
    public function delete($user, $post)
    {
        return $user->can('manageClassroom', $post);
    }
    
    public function restore($user, $post)
    {
        return $user->can('manageClassroom', $post);
    }
    
    public function forceDelete($user, $post)
    {
        return $user->can('manageClassroom', $post);
    }
}
