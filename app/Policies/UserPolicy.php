<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    /**
     * Checa se o usuário logado é admin.
     *
     * @return bool
     */
    public function isAdmin(User $user)
    {
        return $user->tipo == User::PROFILE_ENUM['admin'];
    }
}
