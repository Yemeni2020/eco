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
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    public function index(Request $request, GetCartAction $getCartAction, QuoteTotalsAction $quoteTotalsAction)
    {
        $cart = $getCartAction->execute($request->user('customer'), $request->session()->getId());
        $cart->loadMissing('items.product');
        $totals = $quoteTotalsAction->execute($cart);

        $items = $cart->items->map(function ($item) {
            $image = $item->product?->image ?? ($item->product?->gallery[0] ?? null);
            if ($image && !str_starts_with($image, 'http://') && !str_starts_with($image, 'https://') && !str_starts_with($image, '/')) {
                $image = Storage::disk('public')->exists("product/{$image}")
                    ? Storage::url("product/{$image}")
                    : Storage::url($image);
            }

            return [
                'id' => $item->id,
                'name' => $item->product?->name ?? '-',
                'qty' => $item->qty,
                'price' => (float) $item->price_snapshot,
                'total' => (float) ($item->price_snapshot * $item->qty),
                'image' => $image,
            ];
        })->values();

        return view('cart', [
            'cartItems' => $items,
            'totals' => $totals,
            'itemsCount' => $cart->items->sum('qty'),
        ]);
    }

    public function store(
        AddToCartRequest $request,
        GetCartAction $getCartAction,
        AddToCartAction $addToCartAction,
        QuoteTotalsAction $quoteTotalsAction,
    ) {
        $cart = $getCartAction->execute($request->user('customer'), $request->session()->getId());
        $product = Product::query()->findOrFail($request->input('product_id'));
        $addToCartAction->execute($cart, $product, (int) $request->input('qty'));

        if ($request->wantsJson()) {
            return $this->respondWithJson($cart, $quoteTotalsAction);
        }

        return redirect()->route('cart');
    }

    public function update(UpdateCartItemRequest $request, int $id, GetCartAction $getCartAction, UpdateCartItemQtyAction $updateCartItemQtyAction)
    {
        $cart = $getCartAction->execute($request->user('customer'), $request->session()->getId());
        $item = CartItem::query()->where('cart_id', $cart->id)->findOrFail($id);
        $updateCartItemQtyAction->execute($item, (int) $request->input('qty'));

        return redirect()->route('cart');
    }

    public function destroy(Request $request, int $id, GetCartAction $getCartAction, RemoveCartItemAction $removeCartItemAction)
    {
        $cart = $getCartAction->execute($request->user('customer'), $request->session()->getId());
        $item = CartItem::query()->where('cart_id', $cart->id)->findOrFail($id);
        $removeCartItemAction->execute($item);

        return redirect()->route('cart');
    }

    private function respondWithJson(Cart $cart, QuoteTotalsAction $quoteTotalsAction, ?string $message = null)
    {
        $cart->refresh();
        $cart->load('items.product');

        $totals = $quoteTotalsAction->execute($cart);

        $items = $cart->items->map(function (CartItem $item) {
            $product = $item->product;
            $price = (float) $item->price_snapshot;

            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'price' => $price,
                'total' => $price * $item->qty,
                'name' => $product?->name,
                'image' => $product?->image,
            ];
        })->values();

        return response()->json([
            'ok' => true,
            'message' => $message ?? __('Item added to cart.'),
            'cart_count' => $items->sum('qty'),
            'item_count' => $items->count(),
            'items' => $items,
            'totals' => $totals,
        ]);
    }
}
