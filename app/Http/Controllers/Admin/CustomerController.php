<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        return view('admin.customers.index', [
            'customers' => Customer::orderByDesc('created_at')->paginate(20),
        ]);
    }

    public function show(Customer $customer)
    {
        return view('admin.customers.show', compact('customer'));
    }

    public function toggleBlock(Customer $customer)
    {
        $customer->isBlocked() ? $customer->unblock() : $customer->block();

        $status = $customer->isBlocked() ? 'Customer blocked.' : 'Customer unblocked.';

        return back()->with('status', $status);
    }
}
