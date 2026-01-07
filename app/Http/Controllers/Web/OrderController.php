<?php

namespace App\Http\Controllers\Web;

use App\Domain\Cart\Actions\GetCartAction;
use App\Domain\Orders\Actions\CreateOrderAction;
use App\Domain\Orders\Actions\QuoteTotalsAction;
use App\Domain\Payments\Actions\InitPaymentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()->orders()->latest()->get()->map(function (Order $order) {
            return [
                'id' => $order->order_number,
                'placed_at' => $order->placed_at,
                'status' => Str::title(str_replace('_', ' ', $order->status)),
                'total' => (float) $order->total,
            ];
        });

        return view('orders', ['orders' => $orders]);
    }

    public function history(Request $request)
    {
        $orders = $request->user()->orders()->latest()->with(['items.product', 'shipments'])->get();
        $mapped = $orders->map(function (Order $order) {
            $delivery = $order->shipments->first()?->delivered_at ?? $order->placed_at;
            return [
                'id' => $order->order_number,
                'date' => $order->placed_at,
                'total' => '$' . number_format($order->total, 2),
                'delivery' => $delivery,
                'items' => $order->items->map(function ($item) {
                    return [
                        'name' => $item->name_snapshot,
                        'price' => '$' . number_format($item->price, 2),
                        'image' => $item->product?->image,
                        'description' => $item->product?->summary ?? '',
                    ];
                })->values()->all(),
            ];
        });

        return view('orders.history', ['orders' => $mapped]);
    }

    public function show(Request $request, string $order)
    {
        $orderModel = Order::query()
            ->where('order_number', $order)
            ->where('user_id', $request->user()->id)
            ->with(['items.product', 'shippingAddress', 'billingAddress', 'payments', 'shipments'])
            ->firstOrFail();

        return view('orders.show', ['order' => $this->mapOrderForView($orderModel)]);
    }

    public function store(CreateOrderRequest $request, GetCartAction $getCartAction, CreateOrderAction $createOrderAction, InitPaymentAction $initPaymentAction)
    {
        $user = $request->user();
        $cart = $getCartAction->execute($user, $request->session()->getId());

        $shipping = Address::query()->where('user_id', $user->id)->findOrFail($request->input('shipping_address_id'));
        $billing = null;
        if ($request->filled('billing_address_id')) {
            $billing = Address::query()->where('user_id', $user->id)->findOrFail($request->input('billing_address_id'));
        }

        $order = $createOrderAction->execute($cart, $shipping, $billing, [
            'payment_method' => $request->input('payment_method'),
            'notes' => $request->input('notes'),
        ]);

        if ($request->input('payment_method') === 'cod') {
            return redirect()->route('orders.success', ['order' => $order->order_number]);
        }

        $payment = $initPaymentAction->execute($order, $request->input('payment_method'));

        return redirect()->away($payment->redirectUrl);
    }

    public function success(Request $request, ?string $order = null)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $orderNumber = $order ?: $request->query('order');
        $orderModel = Order::query()
            ->where('order_number', $orderNumber)
            ->where('user_id', $user->id)
            ->with(['items.product', 'shippingAddress', 'billingAddress', 'payments', 'shipments'])
            ->firstOrFail();

        return view('orders.success', [
            'order' => $this->mapOrderForView($orderModel),
        ]);
    }

    public function failed(Request $request, ?string $order = null)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $orderNumber = $order ?: $request->query('order');
        $orderModel = Order::query()
            ->where('order_number', $orderNumber)
            ->where('user_id', $user->id)
            ->with(['items.product', 'shippingAddress', 'billingAddress', 'payments', 'shipments'])
            ->firstOrFail();

        $data = $this->mapOrderForView($orderModel);
        $data['payment_status'] = 'failed';

        return view('orders.success', ['order' => $data]);
    }

    public function invoice(Request $request, string $order)
    {
        $orderModel = Order::query()
            ->where('order_number', $order)
            ->where('user_id', $request->user()->id)
            ->with(['items.product', 'shippingAddress', 'billingAddress', 'payments', 'shipments'])
            ->firstOrFail();

        $data = $this->mapOrderForView($orderModel);

        $format = $request->query('format');
        if ($format === 'excel') {
            $rows = [
                ['Item', 'Qty', 'Price', 'Line Total'],
            ];
            foreach ($data['items'] as $item) {
                $rows[] = [
                    $item['name'] ?? 'Item',
                    (string) ($item['qty'] ?? 1),
                    number_format($item['price'] ?? 0, 2),
                    number_format(($item['price'] ?? 0) * ($item['qty'] ?? 1), 2),
                ];
            }
            $rows[] = ['Subtotal', '', '', number_format($data['subtotal'] ?? 0, 2)];
            $rows[] = ['Shipping', '', '', number_format($data['shipping'] ?? 0, 2)];
            $rows[] = ['Tax', '', '', number_format($data['tax'] ?? 0, 2)];
            $rows[] = ['Total', '', '', number_format($data['total'] ?? 0, 2)];

            return downloadCsv("{$data['id']}-invoice", $rows);
        }

        if ($format === 'pdf') {
            return renderStyledPdf('orders.partials.invoice-body', [
                'orderNumber' => $data['id'],
                'items' => $data['items'],
                'placedAt' => $data['placed_at'],
                'billingAddress' => $data['billing_address'],
                'shippingAddress' => $data['shipping_address'],
                'payment' => $data['payment'],
                'shipping' => $data['shipping'],
                'tax' => $data['tax'],
                'subtotal' => $data['subtotal'],
                'total' => $data['total'],
                'showActions' => false,
            ], "{$data['id']}-invoice");
        }

        return view('orders.invoice', ['order' => $data]);
    }

    public function receipt(Request $request, string $order)
    {
        $orderModel = Order::query()
            ->where('order_number', $order)
            ->where('user_id', $request->user()->id)
            ->with(['items.product', 'shippingAddress', 'billingAddress', 'payments', 'shipments'])
            ->firstOrFail();

        $data = $this->mapOrderForView($orderModel);

        $format = $request->query('format');
        if ($format === 'excel') {
            $rows = [
                ['Item', 'Qty', 'Price', 'Line Total'],
            ];
            foreach ($data['items'] as $item) {
                $rows[] = [
                    $item['name'] ?? 'Item',
                    (string) ($item['qty'] ?? 1),
                    number_format($item['price'] ?? 0, 2),
                    number_format(($item['price'] ?? 0) * ($item['qty'] ?? 1), 2),
                ];
            }
            $rows[] = ['Total paid', '', '', number_format($data['total'] ?? 0, 2)];

            return downloadCsv("{$data['id']}-receipt", $rows);
        }

        if ($format === 'pdf') {
            return renderStyledPdf('orders.partials.receipt-body', [
                'orderNumber' => $data['id'],
                'items' => $data['items'],
                'placedAt' => $data['placed_at'],
                'contact' => $data['contact'],
                'payment' => $data['payment'],
                'total' => $data['total'],
                'showActions' => false,
            ], "{$data['id']}-receipt");
        }

        return view('orders.receipt', ['order' => $data]);
    }

    private function mapOrderForView(Order $order): array
    {
        $order->loadMissing('shipments');
        $payment = $order->payments()->latest()->first();
        $status = Str::title(str_replace('_', ' ', $order->status));
        $shipment = $order->shipments->sortByDesc('shipped_at')->first();

        $shipping = $order->shippingAddress;
        $billing = $order->billingAddress ?? $shipping;
        $contactEmail = $order->user?->email ?? '';
        $contactPhone = $shipping?->phone ?? '';

        $items = $order->items->map(function ($item) use ($order) {
            $statusMeta = $this->mapStatusMeta($order->status);
            return [
                'name' => $item->name_snapshot,
                'price' => (float) $item->price,
                'qty' => $item->qty,
                'description' => $item->product?->summary ?? '',
                'image' => $item->product?->image,
                'status' => $statusMeta,
            ];
        })->values()->all();

        return [
            'id' => $order->order_number,
            'placed_at' => $order->placed_at,
            'status' => $status,
            'payment_status' => $order->payment_status,
            'tracking_number' => $shipment?->tracking_number,
            'shipping_method' => $shipment?->carrier,
            'shipping_eta' => $shipment?->delivered_at?->toFormattedDateString()
                ?? $shipment?->shipped_at?->toFormattedDateString(),
            'coupon_code' => null,
            'contact' => [
                'email' => $contactEmail,
                'phone' => $contactPhone,
            ],
            'shipping_address' => [
                'name' => $shipping?->name,
                'line1' => $shipping?->street,
                'city' => $shipping?->city,
                'region' => $shipping?->district,
                'postal' => $shipping?->postal_code,
                'country' => 'Saudi Arabia',
            ],
            'billing_address' => [
                'name' => $billing?->name,
                'line1' => $billing?->street,
                'city' => $billing?->city,
                'region' => $billing?->district,
                'postal' => $billing?->postal_code,
                'country' => 'Saudi Arabia',
            ],
            'payment' => [
                'brand' => Str::title($payment?->provider ?? ($order->payment_method ?? '')),
                'last4' => $payment?->provider_reference ? substr($payment->provider_reference, -4) : null,
                'exp_month' => null,
                'exp_year' => null,
            ],
            'discount_total' => (float) $order->discount_total,
            'items' => $items,
            'shipping' => (float) $order->shipping_fee,
            'tax' => (float) $order->tax_total,
            'subtotal' => (float) $order->subtotal,
            'total' => (float) $order->total,
        ];
    }

    private function mapStatusMeta(string $status): array
    {
        return match ($status) {
            'delivered' => ['label' => 'Delivered', 'text' => 'Delivered', 'progress' => 100],
            'shipped' => ['label' => 'Shipped', 'text' => 'Shipped', 'progress' => 70],
            'processing' => ['label' => 'Processing', 'text' => 'Processing', 'progress' => 35],
            'cancelled' => ['label' => 'Cancelled', 'text' => 'Cancelled', 'progress' => 0],
            default => ['label' => 'Pending', 'text' => 'Pending', 'progress' => 20],
        };
    }
}
