<?php

namespace App\Policies;

use App\User;
use App\UserPhone;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPhonePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user phone.
     *
     * @param  \App\User  $user
     * @param  \App\UserPhone  $userPhone
     * @return mixed
     */
    public function view(User $user, UserPhone $userPhone)
    {
        return $user->id === $userPhone->user_id ?: abort(404);
    }
}
