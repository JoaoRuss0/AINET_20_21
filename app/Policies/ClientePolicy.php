<?php

namespace App\Policies;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Cliente $cliente)
    {
        return $user->id == $cliente->id;
    }

    public function delete(User $user, Cliente $cliente)
    {
        return $user->tipo == 'A';
    }
}
