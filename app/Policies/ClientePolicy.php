<?php

namespace App\Policies;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Cliente $cliente)
    {
        return $user->id == $cliente->id;
    }

    public function update(User $user, Cliente $cliente)
    {
        return $user->id == $cliente->id;
    }

    public function delete(User $user)
    {
        return $user->tipo == 'A';
    }
}
