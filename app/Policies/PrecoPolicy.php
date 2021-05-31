<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Preco;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrecoPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if($user->tipo == 'A')
        {
            return true;
        }
    }

    public function update(User $user, Preco $preco)
    {
        return false;
    }
}
