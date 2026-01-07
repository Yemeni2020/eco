<?php

namespace App\Http\Controllers\Web;

use App\Domain\Orders\Actions\CancelOrderAction;
use App\Domain\Orders\Actions\MarkOrderPaidAction;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentReturnController extends Controller
{
    public function handle(string $provider, Request $request, MarkOrderPaidAction $markOrderPaidAction, CancelOrderAction $cancelOrderAction)
    {
        $orderNumber = $request->query('order');
        $status = strtolower($request->query('status', 'paid'));

        if ($provider === 'mock' && $orderNumber) {
            $order = Order::query()->where('order_number', $orderNumber)->first();
            if ($order) {
                if ($status === 'paid') {
                    $markOrderPaidAction->execute($order);
                } else {
                    $cancelOrderAction->execute($order);
                }
            }
        }

        if ($orderNumber) {
            return redirect()->route('orders.success', ['order' => $orderNumber]);
        }

        return redirect()->route('orders.failed');
    }

    public function cancel(string $provider, Request $request, CancelOrderAction $cancelOrderAction)
    {
        $orderNumber = $request->query('order');
        if ($orderNumber) {
            $order = Order::query()->where('order_number', $orderNumber)->first();
            if ($order) {
                $cancelOrderAction->execute($order);
            }
        }

        return redirect()->route('orders.failed', ['order' => $orderNumber]);
    }
}
