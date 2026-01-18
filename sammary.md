**Project Audit Summary**

- **Routes & Entry Points** – Web routes (`routes/web.php`, `routes/admin.php`, `routes/settings.php`) handle storefront, localized catalog pages, OTP login, admin dashboard, settings, and locale switching; API routes (`routes/api.php`) expose catalog, cart, order, payment, and Sanctum-protected admin product CRUD endpoints.
- **Catalog & Cart** – Domain/Catalog actions feed product/category controllers plus Livewire widgets (`app/Domain/Catalog/Actions`, `resources/views/pages/shop/index.blade.php`, `resources/views/livewire/home.blade.php`); cart uses `GetCartAction`, `AddToCartAction`, Livewire sidebar (`app/Livewire/CartSidebar.php`), and the shared JS bridge (`resources/views/components/layouts/layouts/app.blade.php`) for real-time badges.
- **Checkout & Orders** – Checkout controller pulls cart, totals, and addresses, but lacks shipping/payment UI; orders rely on `CreateOrderAction` and `InitPaymentAction` to persist data and hand off to payment gateways (`app/Http/Controllers/Web/OrderController.php`, `app/Domain/Orders/Actions/CreateOrderAction.php`).
- **Payments** – Gateway resolver supports Mada, STC Pay, and mock drivers (`app/Domain/Payments/PaymentGatewayResolver.php`, `app/Domain/Payments/Gateways/*.php`); `InitPaymentAction` records payments/sites and webhooks handled via API routes (`routes/api.php`).
- **Admin & Auth** – Volt-based admin shell with customers/product management (`routes/admin.php`, `resources/views/admin/customers/*.blade.php`), segregated guards, OTP for customers, block middleware, and a view composer for cart badges (`app/Models/{Admin,Customer}.php`, `app/Http/Controllers/Auth/PhoneLoginController.php`, `app/Providers/AppServiceProvider.php`).
- **Missing/Risky Items** – Checkout lacks shipping/payment selection; payment gateways are stubbed (no API calls/refund support); shipping/carrier models unused; API cart/order endpoints lack rate limiting; webhook verification is minimal; translation/SEO tooling is limited.
- **Architecture Notes** – Domain actions keep controllers concise but some mapping logic (e.g., order view model) should move to DTOs; models include casts/relations, but migrations lack constraints in places.
- **Roadmap Highlights** – P0: fix admin logout guard and throttle API writes; P1: build shipping/payment choice screens and integrate real payment SDKs; P2: add translation management, caching, queue-based notifications, and shipping automation.
- **Quick Wins** – Ensure cart composer logs failures, throttle API cart writes, create shipment entries during order creation for visibility.
- **Run & Test** – Standard flow: `.env`, `composer install`, `php artisan key:generate`, `php artisan migrate --seed`, `php artisan storage:link`, `npm install && npm run build`, `php artisan test` (check `PhoneLoginTest`, `AddToCartJsonTest`), optionally `php artisan queue:work`.

**Next steps checklist**
- [ ] Point admin sidebar logout form to `route('admin.logout')` so the admin guard ends correctly (`resources/views/admin/components/layouts/app/sidebar.blade.php`).
- [ ] Add rate limiting/auth enforcement to API cart and order-write endpoints (`routes/api.php`).
- [ ] Build shipping/payment choice UI on the checkout page with validation (`resources/views/checkout.blade.php`, `app/Http/Controllers/Web/CheckoutController.php`).
- [ ] Implement real Mada/STC Pay flows with actual SDK/API calls, signature validation, and webhook idempotency (`app/Domain/Payments/Gateways/*.php`, `app/Domain/Payments/Actions/HandleWebhookAction.php`).
- [ ] Create/update shipment and inventory records when orders transition through processing/delivered (`app/Domain/Orders/Actions/CreateOrderAction.php`, `app/Models/Shipment.php`).
