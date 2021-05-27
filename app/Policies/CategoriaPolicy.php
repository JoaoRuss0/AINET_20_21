<?php

namespace App\Policies;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoriaPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if($user->tipo == 'A')
        {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        return false;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Categoria $categoria)
    {
        return false;
    }

    public function delete(User $user, Categoria $categoria)
    {
        return false;
    }
}
