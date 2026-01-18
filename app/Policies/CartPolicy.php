<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\Customer;

class CartPolicy
{
    public function view(Customer $user, Cart $cart): bool
    {
        return (int) $cart->user_id === (int) $user->id;
    }
}
