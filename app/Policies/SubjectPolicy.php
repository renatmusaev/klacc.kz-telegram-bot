<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class SubjectPolicy
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
        return Gate::any(['viewSubject', 'manageSubject'], $user);
    }
    
    public function view($user, $post)
    {
        return Gate::any(['viewSubject', 'manageSubject'], $user, $post);
    }
    
    public function create($user)
    {
        return $user->can('manageSubject');
    }
    
    public function update($user, $post)
    {
        return $user->can('manageSubject', $post);
    }
    
    public function delete($user, $post)
    {
        return $user->can('manageSubject', $post);
    }
    
    public function restore($user, $post)
    {
        return $user->can('manageSubject', $post);
    }
    
    public function forceDelete($user, $post)
    {
        return $user->can('manageSubject', $post);
    }
}
