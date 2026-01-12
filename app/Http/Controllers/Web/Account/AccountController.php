<?php

namespace App\Http\Controllers\Web\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $ordersQuery = $request->user()->orders();

        return view('account.dashboard', [
            'ordersCount' => $ordersQuery->count(),
            'totalSpent' => (float) $ordersQuery->sum('total'),
            'recentOrders' => $ordersQuery->latest()->limit(3)->get(),
        ]);
    }
}
