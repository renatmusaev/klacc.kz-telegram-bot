<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class PagePaymentPolicy
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
        return Gate::any(['viewPagePayment', 'managePagePayment'], $user);
    }
    
    public function view($user, $post)
    {
        return Gate::any(['viewPagePayment', 'managePagePayment'], $user, $post);
    }
    
    public function create($user)
    {
        return $user->can('managePagePayment');
    }
    
    public function update($user, $post)
    {
        return $user->can('managePagePayment', $post);
    }
    
    public function delete($user, $post)
    {
        return $user->can('managePagePayment', $post);
    }
    
    public function restore($user, $post)
    {
        return $user->can('managePagePayment', $post);
    }
    
    public function forceDelete($user, $post)
    {
        return $user->can('managePagePayment', $post);
    }
}
