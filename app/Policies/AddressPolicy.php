<?php

namespace App\Policies;

use App\Models\Address;
use App\Models\Customer;

class AddressPolicy
{
    public function view(Customer $user, Address $address): bool
    {
        return (int) $address->user_id === (int) $user->id;
    }

    public function update(Customer $user, Address $address): bool
    {
        return (int) $address->user_id === (int) $user->id;
    }

    public function delete(Customer $user, Address $address): bool
    {
        return (int) $address->user_id === (int) $user->id;
    }
}
