<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(12);
        $stats = [
            'total' => Product::count(),
            'active' => Product::where('is_active', true)->count(),
            'low_stock' => Product::where('stock', '<=', 5)->count(),
            'drafts' => Product::where('is_active', false)->count(),
        ];

        return view('admin.products.index', compact('products', 'stats'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'slug' => $request->input('slug') ?: Str::slug((string) $request->input('name')),
        ]);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:products,slug'],
            'summary' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku'],
            'stock' => ['required', 'integer', 'min:0'],
            'weight_grams' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $data['is_active'] = (bool) $request->input('is_active', true);

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Product created.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->merge([
            'slug' => $request->input('slug') ?: Str::slug((string) $request->input('name')),
        ]);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($product->id)],
            'summary' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0'],
            'sku' => ['required', 'string', 'max:255', Rule::unique('products', 'sku')->ignore($product->id)],
            'stock' => ['required', 'integer', 'min:0'],
            'weight_grams' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $data['is_active'] = (bool) $request->input('is_active', true);

        $product->update($data);

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Product updated.');
    }
}
