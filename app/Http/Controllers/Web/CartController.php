<?php

namespace App\Http\Controllers\Web;

use App\Domain\Cart\Actions\AddToCartAction;
use App\Domain\Cart\Actions\GetCartAction;
use App\Domain\Cart\Actions\RemoveCartItemAction;
use App\Domain\Cart\Actions\UpdateCartItemQtyAction;
use App\Domain\Orders\Actions\QuoteTotalsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request, GetCartAction $getCartAction, QuoteTotalsAction $quoteTotalsAction)
    {
        $cart = $getCartAction->execute($request->user(), $request->session()->getId());
        $cart->loadMissing('items.product');
        $totals = $quoteTotalsAction->execute($cart);

        $items = $cart->items->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->product?->name ?? '-',
                'qty' => $item->qty,
                'price' => (float) $item->price_snapshot,
                'total' => (float) ($item->price_snapshot * $item->qty),
                'image' => $item->product?->image ?? ($item->product?->gallery[0] ?? null),
            ];
        })->values();

        return view('cart', [
            'cartItems' => $items,
            'totals' => $totals,
            'itemsCount' => $cart->items->sum('qty'),
        ]);
    }

    public function store(AddToCartRequest $request, GetCartAction $getCartAction, AddToCartAction $addToCartAction)
    {
        $cart = $getCartAction->execute($request->user(), $request->session()->getId());
        $product = Product::query()->findOrFail($request->input('product_id'));
        $addToCartAction->execute($cart, $product, (int) $request->input('qty'));

        return redirect()->route('cart');
    }

    public function update(UpdateCartItemRequest $request, int $id, GetCartAction $getCartAction, UpdateCartItemQtyAction $updateCartItemQtyAction)
    {
        $cart = $getCartAction->execute($request->user(), $request->session()->getId());
        $item = CartItem::query()->where('cart_id', $cart->id)->findOrFail($id);
        $updateCartItemQtyAction->execute($item, (int) $request->input('qty'));

        return redirect()->route('cart');
    }

    public function destroy(Request $request, int $id, GetCartAction $getCartAction, RemoveCartItemAction $removeCartItemAction)
    {
        $cart = $getCartAction->execute($request->user(), $request->session()->getId());
        $item = CartItem::query()->where('cart_id', $cart->id)->findOrFail($id);
        $removeCartItemAction->execute($item);

        return redirect()->route('cart');
    }
}
