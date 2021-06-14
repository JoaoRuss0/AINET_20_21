<?php

namespace App\Policies;

use App\Models\Encomenda;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EncomendaPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->tipo == 'C';
    }

    public function view(User $user, Encomenda $encomenda)
    {
        return $user->id == $encomenda->cliente_id || $user->tipo == 'F' && ($encomenda->estado == 'paga' || $encomenda->estado == 'pendente') || $user->tipo == 'A';
    }

    public function update(User $user, Encomenda $encomenda)
    {
        return $user->tipo != 'C';
    }
}
