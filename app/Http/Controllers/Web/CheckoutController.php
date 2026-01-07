<?php

namespace App\Http\Controllers\Web;

use App\Domain\Cart\Actions\GetCartAction;
use App\Domain\Orders\Actions\QuoteTotalsAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request, GetCartAction $getCartAction, QuoteTotalsAction $quoteTotalsAction)
    {
        $user = $request->user();
        $cart = $getCartAction->execute($user, $request->session()->getId());
        $totals = $quoteTotalsAction->execute($cart);

        $addresses = $user?->addresses()->orderByDesc('is_default')->get() ?? collect();
        $defaultAddress = $addresses->first();
        $cartItems = $cart->items->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->product?->name ?? '-',
                'price' => (float) $item->price_snapshot,
                'qty' => $item->qty,
                'image' => $item->product?->image ?? ($item->product?->gallery[0] ?? null),
            ];
        })->values();

        return view('checkout', [
            'totals' => $totals,
            'addresses' => $addresses,
            'defaultAddress' => $defaultAddress,
            'itemsCount' => $cart->items->sum('qty'),
            'cartItems' => $cartItems,
        ]);
    }
}
