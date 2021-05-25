<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->tipo == 'A';
    }

    public function create(User $user)
    {
        return $user->tipo == 'A';
    }

    public function update(User $user, User $model)
    {
        // Only the own user can edit himself
        // Or an admin but the user can't be a client
        return $user->id == $model->id || ($model->tipo == 'A' || $model->tipo == 'F') && $user->tipo == 'A';
    }

    public function delete(User $user, User $model)
    {
        return $user->tipo == 'A';
    }
}
