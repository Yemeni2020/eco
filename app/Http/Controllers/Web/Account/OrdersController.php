<?php

namespace App\Http\Controllers\Web\Account;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->latest()
            ->with(['items.product', 'shipments'])
            ->get();

        return view('account.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function show(Request $request, string $orderNumber)
    {
        $order = Order::query()
            ->where('order_number', $orderNumber)
            ->where('user_id', $request->user()->id)
            ->with(['items.product', 'shippingAddress', 'billingAddress', 'payments', 'shipments'])
            ->firstOrFail();

        return view('account.orders.show', [
            'order' => $order,
        ]);
    }
}
