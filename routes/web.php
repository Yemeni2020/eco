<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Livewire\ProductDetail;
use App\Livewire\Home;
use Spatie\Browsershot\Browsershot;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');
Route::get('/home', function () {
    return view('home');
})->name('home');

Route::view('admin/login', 'admin.auth.login')
    ->middleware('guest')
    ->name('admin.login');

Route::view('admin', 'admin.dashboard')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

if (!function_exists('demoOrders')) {
    /**
     * Temporary demo order data until real persistence is wired.
     *
     * @return array<string, array>
     */
    function demoOrders(): array
    {
        return [
            'ORD-10234' => [
                'id' => 'ORD-10234',
                'placed_at' => '2024-09-15',
                'status' => 'Shipped',
                'customer' => 'Floyd Miles',
                'contact' => ['email' => 'floyd.miles@example.com', 'phone' => '+1 416-555-0140'],
                'shipping_address' => [
                    'name' => 'Floyd Miles',
                    'line1' => '7363 Cynthia Pass',
                    'city' => 'Toronto',
                    'region' => 'ON',
                    'postal' => 'N3Y 4H8',
                    'country' => 'Canada',
                ],
                'billing_address' => [
                    'name' => 'Floyd Miles',
                    'line1' => '7363 Cynthia Pass',
                    'city' => 'Toronto',
                    'region' => 'ON',
                    'postal' => 'N3Y 4H8',
                    'country' => 'Canada',
                ],
                'payment' => [
                    'brand' => 'Visa',
                    'last4' => '4242',
                    'exp_month' => '02',
                    'exp_year' => '24',
                ],
                'items' => [
                    [
                        'name' => 'All-Weather Floor Mats Pro',
                        'price' => 49.99,
                        'qty' => 1,
                        'description' => 'Heavy-duty rubber mats with raised edges for winter protection.',
                        'image' => 'https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?w=300&q=80',
                        'status' => ['label' => 'Processing', 'text' => 'Processing, ships tomorrow', 'progress' => 35],
                    ],
                    [
                        'name' => 'Smart Trunk Organizer',
                        'price' => 34.99,
                        'qty' => 1,
                        'description' => 'Collapsible cargo organizer with modular dividers and tie-downs.',
                        'image' => 'https://images.unsplash.com/photo-1581235720704-06d3acfcb36f?w=300&q=80',
                        'status' => ['label' => 'Preparing', 'text' => 'Preparing to ship', 'progress' => 25],
                    ],
                    [
                        'name' => 'Performance LED Headlights',
                        'price' => 79.99,
                        'qty' => 1,
                        'description' => '6000K cool white bulbs with CANBUS support and 5-year warranty.',
                        'image' => 'https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?w=300&q=80',
                        'status' => ['label' => 'Shipped', 'text' => 'Shipped', 'progress' => 70],
                    ],
                ],
                'shipping' => 7.99,
                'tax' => 17.03,
                'total' => 189.99,
            ],
            'ORD-10212' => [
                'id' => 'ORD-10212',
                'placed_at' => '2024-08-30',
                'status' => 'Delivered',
                'customer' => 'Floyd Miles',
                'contact' => ['email' => 'floyd.miles@example.com', 'phone' => '+1 416-555-0140'],
                'shipping_address' => [
                    'name' => 'Floyd Miles',
                    'line1' => '7363 Cynthia Pass',
                    'city' => 'Toronto',
                    'region' => 'ON',
                    'postal' => 'N3Y 4H8',
                    'country' => 'Canada',
                ],
                'billing_address' => [
                    'name' => 'Floyd Miles',
                    'line1' => '7363 Cynthia Pass',
                    'city' => 'Toronto',
                    'region' => 'ON',
                    'postal' => 'N3Y 4H8',
                    'country' => 'Canada',
                ],
                'payment' => [
                    'brand' => 'Visa',
                    'last4' => '4242',
                    'exp_month' => '02',
                    'exp_year' => '24',
                ],
                'items' => [
                    [
                        'name' => 'All-Weather Floor Mats Pro',
                        'price' => 49.99,
                        'qty' => 1,
                        'description' => 'Heavy-duty rubber mats with raised edges for winter protection.',
                        'image' => 'https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?w=300&q=80',
                        'status' => ['label' => 'Delivered', 'text' => 'Delivered', 'progress' => 100],
                    ],
                    [
                        'name' => 'Smart Trunk Organizer',
                        'price' => 34.99,
                        'qty' => 1,
                        'description' => 'Collapsible cargo organizer with modular dividers and tie-downs.',
                        'image' => 'https://images.unsplash.com/photo-1581235720704-06d3acfcb36f?w=300&q=80',
                        'status' => ['label' => 'Delivered', 'text' => 'Delivered', 'progress' => 100],
                    ],
                ],
                'shipping' => 0.00,
                'tax' => 0.00,
                'total' => 84.98,
            ],
        ];
    }
}

if (!function_exists('downloadCsv')) {
    /**
     * Stream a simple CSV string with provided filename.
     */
    function downloadCsv(string $filename, array $rows): \Symfony\Component\HttpFoundation\Response
    {
        $csv = collect($rows)->map(fn ($row) => implode(',', array_map(fn ($v) => '"' . str_replace('"', '""', $v) . '"', $row)))->implode("\n");
        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
        ]);
    }
}

if (!function_exists('inlineStyles')) {
    /**
     * Load compiled app CSS or fall back to a CDN Tailwind build.
     */
    function inlineStyles(): string
    {
        $buildCss = collect(glob(public_path('build/assets/app-*.css')))->first();
        if ($buildCss && file_exists($buildCss)) {
            return '<style>' . file_get_contents($buildCss) . '</style>';
        }
        return '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.3/dist/tailwind.min.css">';
    }
}

if (!function_exists('renderStyledPdf')) {
    /**
     * Render a Blade partial inside a minimal wrapper and return it as a PDF download.
     */
    function renderStyledPdf(string $view, array $data, string $filename): \Symfony\Component\HttpFoundation\Response
    {
        $styles = inlineStyles();
        $html = view('orders.pdf-wrapper', [
            'styles' => $styles,
            'slot' => view($view, $data)->render(),
        ])->render();

        $pdf = Browsershot::html($html)
            ->format('A4')
            ->landscape()
            ->margins(12, 12, 18, 12)
            ->showBackground()
            ->emulateMedia('screen')
            ->timeout(120000)
            ->pdf();

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"{$filename}.pdf\"",
        ]);
    }
}
Route::get('/', Home::class)->name('home');
// About Page
Route::get('/about', function () {
    return view('about'); // resources/views/about.blade.php
})->name('about');
Route::get('/shop', function () {
    return view('pages.shop.index'); // resources/views/about.blade.php
})->name('shop');

// Contact Page
Route::get('/contact', function () {
    return view('contact'); // resources/views/contact.blade.php
})->name('contact');

// Profile / Orders / Wishlist
Route::view('/profile', 'profile')->name('profile');
Route::view('/login', 'pages.login')->name('login');
Route::view('/signup', 'pages.signup')->name('signup');
Route::view('/reset-password', 'pages.reset-password')->name('password.reset');
Route::view('/otp', 'pages.otp')->name('otp');
Route::view('/settings', 'pages.settings')->name('settings');
Route::view('/orders/history', 'orders.history')->name('orders.history');
Route::view('/orders/success', 'orders.success')->name('orders.success');
Route::post('/orders/place', function () {
    $redirect = request('redirect', '/orders/success');
    return redirect($redirect);
})->name('orders.place');
Route::get('/orders', function () {
    $orders = demoOrders();
    return view('orders', ['orders' => array_values($orders)]);
})->name('orders');
Route::get('/orders/{order}', function (string $order) {
    $orders = demoOrders();
    $orderData = $orders[$order] ?? null;
    if (!$orderData) {
        abort(404);
    }
    return view('orders.show', ['order' => $orderData]);
})->name('orders.show');
Route::get('/orders/{order}/invoice', function (string $order) {
    $orders = demoOrders();
    $orderData = $orders[$order] ?? null;
    if (!$orderData) {
        abort(404);
    }
    $orderNumber = $orderData['id'] ?? 'INV-0000';
    $items = $orderData['items'] ?? [];
    $placedAt = $orderData['placed_at'] ?? '2021-03-22';
    $billingAddress = $orderData['billing_address'] ?? [];
    $shippingAddress = $orderData['shipping_address'] ?? $billingAddress;
    $payment = $orderData['payment'] ?? ['brand' => 'Card', 'last4' => '0000'];
    $shipping = $orderData['shipping'] ?? 0;
    $tax = $orderData['tax'] ?? 0;
    $subtotal = array_reduce($items, fn ($carry, $item) => $carry + (($item['price'] ?? 0) * ($item['qty'] ?? 1)), 0);
    $total = $orderData['total'] ?? ($subtotal + $shipping + $tax);
    $format = request()->query('format');
    if ($format === 'excel') {
        $rows = [
            ['Item', 'Qty', 'Price', 'Line Total'],
        ];
        foreach ($orderData['items'] ?? [] as $item) {
            $price = $item['price'] ?? 0;
            $qty = $item['qty'] ?? 1;
            $rows[] = [
                $item['name'] ?? 'Item',
                (string) $qty,
                number_format($price, 2),
                number_format($price * $qty, 2),
            ];
        }
        $rows[] = ['Subtotal', '', '', number_format(array_reduce($orderData['items'] ?? [], fn ($carry, $it) => $carry + (($it['price'] ?? 0) * ($it['qty'] ?? 1)), 0), 2)];
        $rows[] = ['Shipping', '', '', number_format($orderData['shipping'] ?? 0, 2)];
        $rows[] = ['Tax', '', '', number_format($orderData['tax'] ?? 0, 2)];
        $rows[] = ['Total', '', '', number_format($orderData['total'] ?? 0, 2)];
        return downloadCsv("{$orderData['id']}-invoice", $rows);
    }
    if ($format === 'pdf') {
        return renderStyledPdf('orders.partials.invoice-body', [
            'orderNumber' => $orderNumber,
            'items' => $items,
            'placedAt' => $placedAt,
            'billingAddress' => $billingAddress,
            'shippingAddress' => $shippingAddress,
            'payment' => $payment,
            'shipping' => $shipping,
            'tax' => $tax,
            'subtotal' => $subtotal,
            'total' => $total,
            'showActions' => false,
        ], "{$orderData['id']}-invoice");
    }

    return view('orders.invoice', ['order' => $orderData]);
})->name('orders.invoice');
Route::get('/orders/{order}/receipt', function (string $order) {
    $orders = demoOrders();
    $orderData = $orders[$order] ?? null;
    if (!$orderData) {
        abort(404);
    }
    $orderNumber = $orderData['id'] ?? 'RCT-0000';
    $items = $orderData['items'] ?? [];
    $placedAt = $orderData['placed_at'] ?? '2021-03-22';
    $contact = $orderData['contact'] ?? ['email' => '-', 'phone' => ''];
    $payment = $orderData['payment'] ?? ['brand' => 'Card', 'last4' => '0000'];
    $total = $orderData['total'] ?? array_reduce($items, fn ($carry, $item) => $carry + (($item['price'] ?? 0) * ($item['qty'] ?? 1)), 0);
    $format = request()->query('format');
    if ($format === 'excel') {
        $rows = [
            ['Item', 'Qty', 'Price', 'Line Total'],
        ];
        foreach ($orderData['items'] ?? [] as $item) {
            $price = $item['price'] ?? 0;
            $qty = $item['qty'] ?? 1;
            $rows[] = [
                $item['name'] ?? 'Item',
                (string) $qty,
                number_format($price, 2),
                number_format($price * $qty, 2),
            ];
        }
        $rows[] = ['Total paid', '', '', number_format($orderData['total'] ?? 0, 2)];
        return downloadCsv("{$orderData['id']}-receipt", $rows);
    }
    if ($format === 'pdf') {
        return renderStyledPdf('orders.partials.receipt-body', [
            'orderNumber' => $orderNumber,
            'items' => $items,
            'placedAt' => $placedAt,
            'contact' => $contact,
            'payment' => $payment,
            'total' => $total,
            'showActions' => false,
        ], "{$orderData['id']}-receipt");
    }

    return view('orders.receipt', ['order' => $orderData]);
})->name('orders.receipt');
Route::view('/wishlist', 'wishlist')->name('wishlist');
Route::view('/notifications', 'notifications')->name('notifications');

// Checkout Page
Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');
Route::get('/cart', function () {
    return view('cart');
})->name('cart');
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', function () {
        return view('categories.index'); // resources/views/categories/index.blade.php
    })->name('index');

    Route::get('/seat-covers', function () {
        return view('categories.seat-covers'); // resources/views/categories/seat-covers.blade.php
    })->name('seat-covers');

    Route::get('/floor-mats', function () {
        return view('categories.floor-mats'); // resources/views/categories/floor-mats.blade.php
    })->name('floor-mats');

    Route::get('/lighting', function () {
        return view('categories.lighting'); // resources/views/categories/lighting.blade.php
    })->name('lighting');

    Route::get('/dash-cams', function () {
        return view('categories.dash-cams'); // resources/views/categories/dash-cams.blade.php
    })->name('dash-cams');
});
Route::get('shop/{productId}', \App\Livewire\ProductDetail::class)->name('shop.show');
// Fallback 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
