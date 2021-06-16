<?php

namespace App\Policies;

use App\Models\Estampa;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EstampaPolicy
{
    use HandlesAuthorization;

    public function view(? User $user, Estampa $estampa)
    {
        if($estampa->cliente_id == null)
        {
            return true;
        }

        if($user != null && $estampa->cliente_id == $user->id)
        {
            return true;
        }

        return false;
    }

    public function viewImage(User $user, Estampa $estampa)
    {
        return $user->id == $estampa->cliente_id || $user->tipo != 'C';
    }

    public function viewOwn(User $user)
    {
        return $user->tipo == 'C';
    }

    public function create(User $user)
    {
        return $user->tipo != 'F';
    }

    public function update(User $user, Estampa $estampa)
    {
        if($estampa->cliente_id == $user->id)
        {
            return true;
        }

        if($estampa->cliente_id == null && $user->tipo == 'A')
        {
            return true;
        }

        return false;
    }

    public function delete(User $user, Estampa $estampa)
    {
        if($estampa->cliente_id == $user->id)
        {
            return true;
        }

        if($estampa->cliente_id == null && $user->tipo == 'A')
        {
            return true;
        }

        return false;
    }
}
