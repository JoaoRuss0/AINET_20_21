<?php

namespace App\Policies;

use App\Models\Estampa;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EstampaPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if($user->tipo == 'A')
        {
            return true;
        }
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Estampa $estampa)
    {
        return false;
    }

    public function delete(User $user, Estampa $estampa)
    {
        return false;
    }
}
