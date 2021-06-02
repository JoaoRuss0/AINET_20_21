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

    public function view(User $user, User $model)
    {
        return $user->tipo == 'A' && $model->tipo != 'C';
    }

    public function create(User $user)
    {
        return $user->tipo == 'A';
    }

    public function update(User $user, User $model)
    {
        // Only an admin can edit/update Admin but the user model can't be a client
        return $model->tipo != 'C' && $user->tipo == 'A';
    }

    public function delete(User $user, User $model)
    {
        return $user->tipo == 'A';
    }

    public function block_destroy_type(User $user, User $model)
    {
        // Admin can't change his own type or block himself or delete himself
        return $user->tipo == 'A' && $user->id != $model->id;
    }
}
