<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\Order;

class OrderPolicy
{
    public function viewAny(Customer $user): bool
    {
        return true;
    }

    public function view(Customer $user, Order $order): bool
    {
        return (int) $order->user_id === (int) $user->id;
    }
}
