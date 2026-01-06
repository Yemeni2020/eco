<x-layouts.app>
    <main class="min-h-screen bg-white py-16">
        <div class="mx-auto w-full max-w-3xl px-4">
            <div class="space-y-4">
                <p class="text-sm font-semibold text-blue-600">Thank you!</p>
                <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">It's on the way!</h1>
                <p class="text-base text-slate-600">
                    Your order #14034056 has shipped and will be with you soon.
                </p>
            </div>

            <dl class="mt-8 space-y-2 text-sm text-slate-700">
                <dt class="font-semibold text-slate-900">Tracking number</dt>
                <dd class="text-blue-600">51547878755545848512</dd>
            </dl>

            <div class="mt-10 border-t border-slate-200 pt-10">
                <h2 class="text-lg font-semibold text-slate-900">Your order</h2>

                <div class="mt-6 border-b border-slate-200 pb-8">
                    <h3 class="text-sm font-semibold text-slate-900">Items</h3>
                    <div class="mt-4 flex flex-col gap-6 sm:flex-row">
                        <div
                            class="h-28 w-28 shrink-0 overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                            <img src="https://tailwindcss.com/plus-assets/img/ecommerce-images/confirmation-page-05-product-01.jpg"
                                alt="Glass bottle with black plastic pour top and mesh insert."
                                class="h-full w-full object-cover">
                        </div>
                        <div class="flex-1 space-y-3">
                            <div>
                                <h4 class="text-base font-semibold text-slate-900">
                                    <a href="#" class="hover:text-slate-700">Cold Brew Bottle</a>
                                </h4>
                                <p class="mt-2 text-sm text-slate-600">
                                    This glass bottle comes with a mesh insert for steeping tea or cold-brewing coffee.
                                    Pour from any angle and remove the top for easy cleaning.
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-6 text-sm text-slate-700">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-slate-900">Quantity</span>
                                    <span>1</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-slate-900">Price</span>
                                    <span>$32.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 border-b border-slate-200 pb-8">
                    <h3 class="text-sm font-semibold text-slate-900">Your information</h3>

                    <div class="mt-4 grid gap-6 sm:grid-cols-2">
                        <div>
                            <h4 class="text-sm font-semibold text-slate-900">Shipping address</h4>
                            <address class="mt-2 not-italic text-sm text-slate-600 space-y-1">
                                <span class="block">Kristin Watson</span>
                                <span class="block">7363 Cynthia Pass</span>
                                <span class="block">Toronto, ON N3Y 4H8</span>
                            </address>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-900">Billing address</h4>
                            <address class="mt-2 not-italic text-sm text-slate-600 space-y-1">
                                <span class="block">Kristin Watson</span>
                                <span class="block">7363 Cynthia Pass</span>
                                <span class="block">Toronto, ON N3Y 4H8</span>
                            </address>
                        </div>
                    </div>

                    <div class="mt-8 grid gap-6 sm:grid-cols-2">
                        <div>
                            <h4 class="text-sm font-semibold text-slate-900">Payment method</h4>
                            <div class="mt-2 text-sm text-slate-600 space-y-1">
                                <p>Apple Pay</p>
                                <p>Mastercard</p>
                                <p><span aria-hidden="true">••••</span> Ending in 1545</p>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-900">Shipping method</h4>
                            <div class="mt-2 text-sm text-slate-600 space-y-1">
                                <p>DHL</p>
                                <p>Takes up to 3 working days</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-sm font-semibold text-slate-900">Summary</h3>
                    <dl class="mt-4 space-y-3 text-sm text-slate-600">
                        <div class="flex items-center justify-between">
                            <dt class="text-slate-900 font-semibold">Subtotal</dt>
                            <dd>$36.00</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="flex items-center gap-2 text-slate-900 font-semibold">
                                Discount
                                <span
                                    class="rounded-full border border-blue-200 bg-blue-50 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-blue-700">Student50</span>
                            </dt>
                            <dd>-$18.00 (50%)</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-slate-900 font-semibold">Shipping</dt>
                            <dd>$5.00</dd>
                        </div>
                        <div class="flex items-center justify-between text-slate-900 font-semibold">
                            <dt>Total</dt>
                            <dd>$23.00</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </main>
</x-layouts.app>
