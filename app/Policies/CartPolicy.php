<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartPolicy
{
    use HandlesAuthorization;

    public function before(? User $user)
    {
        if(Auth::guest() || $user->tipo == 'C')
        {
            return true;
        }
    }

    public function view(User $user)
    {
        return false;
    }

    public function update(User $user)
    {
        return false;
    }

    public function delete(User $user)
    {
        return false;
    }
}
