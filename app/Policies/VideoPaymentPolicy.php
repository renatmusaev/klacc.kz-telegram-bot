<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class VideoPaymentPolicy
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
        return Gate::any(['viewVideoPayment', 'manageVideoPayment'], $user);
    }
    
    public function view($user, $post)
    {
        return Gate::any(['viewVideoPayment', 'manageVideoPayment'], $user, $post);
    }
    
    public function create($user)
    {
        return $user->can('manageVideoPayment');
    }
    
    public function update($user, $post)
    {
        return $user->can('manageVideoPayment', $post);
    }
    
    public function delete($user, $post)
    {
        return $user->can('manageVideoPayment', $post);
    }
    
    public function restore($user, $post)
    {
        return $user->can('manageVideoPayment', $post);
    }
    
    public function forceDelete($user, $post)
    {
        return $user->can('manageVideoPayment', $post);
    }
}
