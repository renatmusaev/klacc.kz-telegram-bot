<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class LessonPaymentPolicy
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
        return Gate::any(['viewLessonPayment', 'manageLessonPayment'], $user);
    }
    
    public function view($user, $post)
    {
        return Gate::any(['viewLessonPayment', 'manageLessonPayment'], $user, $post);
    }
    
    public function create($user)
    {
        return $user->can('manageLessonPayment');
    }
    
    public function update($user, $post)
    {
        return $user->can('manageLessonPayment', $post);
    }
    
    public function delete($user, $post)
    {
        return $user->can('manageLessonPayment', $post);
    }
    
    public function restore($user, $post)
    {
        return $user->can('manageLessonPayment', $post);
    }
    
    public function forceDelete($user, $post)
    {
        return $user->can('manageLessonPayment', $post);
    }
}
