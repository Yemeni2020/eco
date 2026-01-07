# Eco Store Backend (Laravel + Blade + API)

Laravel backend for a physical goods store in Saudi Arabia. Blade pages and the `/api/v1` REST API share the same Domain actions for catalog, cart, orders, and payments.

## Setup

1. `composer install`
2. `copy .env.example .env`
3. Set database credentials in `.env`.
4. `php artisan key:generate`
5. `php artisan migrate:fresh --seed`
6. `php artisan serve`

Seeded demo user:
- Email: `demo@example.com`
- Password: `password`

Queue (webhook processing runs through a queued job; default queue driver is `sync`):
- Optional: set `QUEUE_CONNECTION=database`, then run `php artisan queue:table && php artisan migrate`
- Start worker: `php artisan queue:work`

## Configuration

Key `.env` values (see `.env.example`):
- `DB_*` for MySQL
- `APP_URL`
- `STORE_CURRENCY` (default `SAR`)
- `STORE_TAX_RATE`, `STORE_SHIPPING_FEE`
- `PAYMENTS_DEFAULT_PROVIDER` (`mada`, `stcpay`, `mock`)
- `PAYMENTS_RETURN_URL`, `PAYMENTS_CANCEL_URL`
- `PAYMENTS_WEBHOOK_SECRET`

## Blade Data Wiring

These pages are populated by controllers using Domain actions:

- `resources/views/livewire/home.blade.php` <- `app/Http/Controllers/Web/HomeController@index` (`$categories`, `$featuredProducts`, `$currency`)
- `resources/views/pages/shop/index.blade.php` <- `app/Http/Controllers/Web/ProductController@index` (`$products`, `$categories`, `$pagination`)
- `resources/views/pages/shop/show.blade.php` <- `app/Http/Controllers/Web/ProductController@show` (`$product`)
- `resources/views/cart.blade.php` <- `app/Http/Controllers/Web/CartController@index` (`$cartItems`, `$totals`, `$itemsCount`)
- `resources/views/checkout.blade.php` <- `app/Http/Controllers/Web/CheckoutController@index` (`$totals`, `$addresses`, `$defaultAddress`, `$itemsCount`, `$cartItems`)
- `resources/views/orders.blade.php` <- `app/Http/Controllers/Web/OrderController@index` (`$orders`)
- `resources/views/orders/history.blade.php` <- `app/Http/Controllers/Web/OrderController@history` (`$orders`)
- `resources/views/orders/show.blade.php` <- `app/Http/Controllers/Web/OrderController@show` (`$order`)
- `resources/views/orders/success.blade.php` <- `app/Http/Controllers/Web/OrderController@success|failed` (`$order`)
- `resources/views/orders/invoice.blade.php` <- `app/Http/Controllers/Web/OrderController@invoice` (`$order`)
- `resources/views/orders/receipt.blade.php` <- `app/Http/Controllers/Web/OrderController@receipt` (`$order`)

Livewire storefront strips demo data and uses Domain actions:
- `app/Livewire/NewArrivals.php` -> `resources/views/livewire/new-arrivals.blade.php`
- `app/Livewire/BestSellers.php` -> `resources/views/livewire/best-sellers.blade.php`
- `app/Livewire/TrendingNow.php` -> `resources/views/livewire/trending-now.blade.php`
- `app/Livewire/CartSidebar.php` -> `resources/views/livewire/cart-sidebar.blade.php`

## API

Base URL: `{{APP_URL}}/api/v1`

Response format:
```json
// Success
{ "success": true, "data": ..., "message": null, "errors": null }

// Error
{ "success": false, "data": null, "message": "...", "errors": { ... } }
```

Guest cart support:
- Use `X-Session-Id` header to persist a guest cart across requests.

Address endpoints (auth):
- `GET /api/v1/addresses`
- `POST /api/v1/addresses`
- `PATCH /api/v1/addresses/{address}`
- `DELETE /api/v1/addresses/{address}`

### Curl examples

Register:
```bash
curl -X POST {{APP_URL}}/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Sara","email":"sara@example.com","password":"secret123","password_confirmation":"secret123"}'
```

Login:
```bash
curl -X POST {{APP_URL}}/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"demo@example.com","password":"password"}'
```

List products:
```bash
curl "{{APP_URL}}/api/v1/products?search=&category=&sort=newest&page=1"
```

Add to cart (guest):
```bash
curl -X POST {{APP_URL}}/api/v1/cart/items \
  -H "Content-Type: application/json" \
  -H "X-Session-Id: demo-session" \
  -d '{"product_id":1,"qty":2}'
```

Checkout quote (auth):
```bash
curl -X POST {{APP_URL}}/api/v1/checkout/quote \
  -H "Authorization: Bearer {{token}}"
```

Create order (auth):
```bash
curl -X POST {{APP_URL}}/api/v1/orders \
  -H "Authorization: Bearer {{token}}" \
  -H "Content-Type: application/json" \
  -d '{"shipping_address_id":1,"billing_address_id":null,"payment_method":"mada","notes":""}'
```

Init payment (auth):
```bash
curl -X POST {{APP_URL}}/api/v1/payments/1/init \
  -H "Authorization: Bearer {{token}}" \
  -H "Content-Type: application/json" \
  -d '{"provider":"mada"}'
```

Payment status (auth):
```bash
curl "{{APP_URL}}/api/v1/payments/1/status" \
  -H "Authorization: Bearer {{token}}"
```

## Payments

Gateway abstraction lives in `app/Domain/Payments`. Configure providers in `config/payments.php`.
- Web return URLs: `/payments/return/{provider}` and `/payments/cancel/{provider}`
- Webhooks: `/api/v1/payments/webhook/mada` and `/api/v1/payments/webhook/stcpay`

For local testing, set `PAYMENTS_DEFAULT=mock` and use `/payments/return/mock?order=ORDER_NUMBER&status=paid`.

## Flutter integration notes

Base URL:
- `https://your-domain.com`

Default headers:
- `Accept: application/json`
- `Content-Type: application/json`
- `Authorization: Bearer <token>` (after login)
- `X-Session-Id: <uuid>` (guest cart)

Token storage:
- Store the token in secure storage (`flutter_secure_storage`) and attach it for authenticated calls.

Sample flow:
1) Register/login -> store token
2) `GET /api/v1/products`
3) `POST /api/v1/cart/items`
4) `POST /api/v1/checkout/quote`
5) `POST /api/v1/orders`
6) `POST /api/v1/payments/{order}/init`
7) `GET /api/v1/payments/{order}/status`

## Postman

Import `postman_collection.json` from the project root and set:
- `baseUrl`
- `token`
- `sessionId`
