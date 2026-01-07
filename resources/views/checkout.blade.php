<x-layouts.app>
    @push('head')
        <style>
            :root {
                --primary: #2563eb;
                --line: #e2e8f0;
                --warn: #fde68a;
                --shadow: 0 18px 40px -24px rgba(15, 23, 42, 0.35);
            }

            .dark {
                --primary: #38bdf8;
                --line: #1f2937;
                --warn: #fcd34d;
                --shadow: 0 18px 40px -24px rgba(0, 0, 0, 0.6);
            }

            .payment-option.is-active {
                border-color: var(--primary);
                box-shadow: 0 0 0 2px color-mix(in srgb, var(--primary) 20%, transparent);
                background-color: #f8fafc;
            }

            .shipping-option.is-active {
                border-color: var(--primary);
                box-shadow: 0 0 0 2px color-mix(in srgb, var(--primary) 20%, transparent);
                background-color: #f8fafc;
            }

            .address-item.is-active {
                border-color: var(--primary);
                background-color: #f8fafc;
            }
        </style>
    @endpush

    @php
        $defaultAddressText = '';
        if (!empty($defaultAddress)) {
            $defaultAddressText = collect([
                $defaultAddress->name,
                $defaultAddress->phone,
                $defaultAddress->city,
                $defaultAddress->district,
                $defaultAddress->street,
            ])->filter()->implode(' - ');
        }
    @endphp

    
    <div id="applePayAlert"
        class="hidden relative isolate flex items-center gap-x-6 overflow-hidden bg-gray-800/50 px-6 py-2.5 after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10 sm:px-3.5 sm:before:flex-1">
        <div aria-hidden="true"
            class="absolute top-1/2 left-[max(-7rem,calc(50%-52rem))] -z-10 -translate-y-1/2 transform-gpu blur-2xl">
            <div style="clip-path: polygon(74.8% 41.9%, 97.2% 73.2%, 100% 34.9%, 92.5% 0.4%, 87.5% 0%, 75% 28.6%, 58.5% 54.6%, 50.1% 56.8%, 46.9% 44%, 48.3% 17.4%, 24.7% 53.9%, 0% 27.9%, 11.9% 74.2%, 24.9% 54.1%, 68.6% 100%, 74.8% 41.9%)"
                class="aspect-577/310 w-144.25 bg-linear-to-r from-[#ff80b5] to-[#9089fc] opacity-40"></div>
        </div>
        <div aria-hidden="true"
            class="absolute top-1/2 left-[max(45rem,calc(50%+8rem))] -z-10 -translate-y-1/2 transform-gpu blur-2xl">
            <div style="clip-path: polygon(74.8% 41.9%, 97.2% 73.2%, 100% 34.9%, 92.5% 0.4%, 87.5% 0%, 75% 28.6%, 58.5% 54.6%, 50.1% 56.8%, 46.9% 44%, 48.3% 17.4%, 24.7% 53.9%, 0% 27.9%, 11.9% 74.2%, 24.9% 54.1%, 68.6% 100%, 74.8% 41.9%)"
                class="aspect-577/310 w-144.25 bg-linear-to-r from-[#ff80b5] to-[#9089fc] opacity-40"></div>
        </div>
        <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
            <p class="text-sm/6 text-gray-100">
                Apple Pay is available only in Safari. Please open this checkout in Safari to pay.
            </p>
            <button type="button" id="copyCheckoutLink"
                class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3.5 py-1 text-sm font-semibold text-white shadow-xs inset-ring-white/20 hover:bg-white/15 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Copy
                link <span aria-hidden="true"><svg viewBox="0 0 24 24" class="h-4 w-4" fill="none"
                        stroke="currentColor" stroke-width="1.7">
                        <path d="M9 9h10v10H9z" />
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                    </svg></span></button>
        </div>
        <div class="flex flex-1 justify-end">
            <button type="button" class="-m-4 p-4 focus-visible:-outline-offset-4" data-dismiss-alert>
                <span class="sr-only">Dismiss</span>
                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true"
                    class="size-5 text-gray-100">
                    <path
                        d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                </svg>
            </button>
        </div>
    </div>

    <main class="min-h-screen bg-slate-50 py-12">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Store header -->
            <x-card
                class="rounded-2xl border border-slate-200/70 bg-white/90 p-6 shadow-[0_20px_50px_-40px_rgba(15,23,42,0.45)] ring-1 ring-slate-900/5">
                <div class="flex items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <a class="grid h-14 w-14 place-items-center rounded-xl  bg-white overflow-hidden shadow-sm"
                            href="#">
                            <img class="h-full w-full object-contain" src="{{ asset('img/logo_avatar.svg') }}"
                                alt="logo">
                        </a>
                        <div>
                            <h1 class="text-lg font-bold leading-6 text-slate-900">{{ config('app.name') }}</h1>
                            <div class="mt-1 text-xs text-slate-500">
                                <a class="hover:text-slate-700" href="{{ route('cart') }}">Cart</a>
                                <span class="mx-2">/</span>
                                <span class="text-slate-700">Checkout</span>
                            </div>
                        </div>
                    </div>

                </div>
            </x-card>

            <!-- Totals + coupon -->
            <x-card
                class="mt-5 rounded-2xl border border-slate-200/70 bg-white/90 shadow-[0_20px_50px_-40px_rgba(15,23,42,0.45)] ring-1 ring-slate-900/5">
                <div class="p-6 flex flex-wrap items-center justify-between gap-2">
                    <div class="text-xl font-extrabold text-slate-900">
                        {{ number_format($totals['total'] ?? 0, 2) }} <span class="text-slate-400">SAR</span>
                    </div>
                    <div class="text-xl font-bold text-slate-900">Order total</div>
                </div>

                <div class="px-6 pb-6">
                    <div class="mb-2 text-sm text-[color:var(--primary)]">Have a discount code?</div>

                    <div class="flex flex-wrap gap-2">
                        <x-input placeholder="Enter coupon code"
                            class="rounded-xl border border-slate-200/70 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200/60" />
                        <x-button type="button" size="md" variant="solid"
                            class="rounded-xl px-5 shadow-sm">Apply</x-button>
                    </div>

                    <div class="mt-4 flex justify-center">
                        <button id="openOrderDetails"
                            class="inline-flex items-center gap-2 rounded-full border border-slate-200/70 bg-white px-5 py-2 text-xs font-semibold text-slate-600 shadow-sm hover:bg-slate-50 hover:text-slate-800 transition"
                            type="button">
                            Order details
                        </button>
                    </div>
                </div>
            </x-card>

            <!-- Main accordion card -->
            <x-card
                class="mt-5 rounded-2xl border border-slate-200/70 bg-white/90 shadow-[0_20px_50px_-40px_rgba(15,23,42,0.45)] ring-1 ring-slate-900/5">
                <!-- Shipping Address header -->
                <button class="w-full p-6 flex items-center justify-between hover:bg-slate-50/70 transition"
                    type="button">
                    <div class="flex items-center gap-2 text-slate-700">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor"
                            stroke-width="1.7">
                            <path d="M12 22s7-4.4 7-11a7 7 0 0 0-14 0c0 6.6 7 11 7 11z" />
                            <circle cx="12" cy="11" r="2.5" />
                        </svg>
                    </div>
                    <div class="text-lg font-bold text-slate-900">Shipping address</div>
                </button>

                <div class="px-6 pb-6">
                    <div id="selectedAddressSummary" class="text-xs text-slate-500 mb-4">
                        {{ $defaultAddressText }}
                    </div>

                    <div class="rounded-xl border border-slate-200/70 bg-white shadow-sm">
                        <div class="flex items-center justify-between px-4 py-3 bg-slate-50/70">
                            <div class="text-sm font-bold text-slate-700">Saved addresses</div>
                            <svg viewBox="0 0 24 24" class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path d="m6 15 6-6 6 6" />
                            </svg>
                        </div>

                        <div id="addressList" class="px-4 py-3 space-y-3">
                            @forelse ($addresses as $address)
                                @php
                                    $addressText = collect([
                                        $address->name,
                                        $address->phone,
                                        $address->city,
                                        $address->district,
                                        $address->street,
                                    ])->filter()->implode(' - ');
                                @endphp
                                <label
                                    class="address-item {{ $address->is_default ? 'is-active' : '' }} flex items-start justify-between gap-3 rounded-lg border border-slate-200/70 p-3"
                                    data-address="{{ $addressText }}">
                                    <div class="flex items-start gap-3">
                                        <input type="radio" name="address"
                                            class="mt-1 accent-[color:var(--primary)]"
                                            @checked($address->is_default)>
                                        <span class="text-sm text-slate-700" data-address-text>
                                            {{ $addressText }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <button class="text-slate-500 hover:text-slate-800" aria-label="edit"
                                            data-edit-address type="button">
                                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none"
                                                stroke="currentColor" stroke-width="1.7">
                                                <path d="M12 20h9" />
                                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                                            </svg>
                                        </button>
                                        <button class="text-red-500 hover:text-red-600" aria-label="delete"
                                            data-delete-address type="button">
                                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none"
                                                stroke="currentColor" stroke-width="1.7">
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4h8v2" />
                                                <path d="M19 6l-1 16H6L5 6" />
                                                <path d="M10 11v6M14 11v6" />
                                            </svg>
                                        </button>
                                    </div>
                                </label>
                            @empty
                                <div class="text-sm text-slate-500">No saved addresses yet.</div>
                            @endforelse

                            <button
                                class="mt-4 w-full rounded-xl border border-slate-200/70 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:border-slate-300 hover:bg-slate-50 transition"
                                type="button" data-add-address>
                                Add new address
                            </button>

                            <div id="addressDialog"
                                class="hidden mt-4 rounded-xl border border-slate-200/70 bg-white p-4 shadow-sm">
                                <div class="text-sm font-semibold text-slate-800">New address</div>
                                <div class="mt-3 grid gap-3 md:grid-cols-2">
                                    <input id="addressName" type="text" placeholder="Full name"
                                        class="rounded-xl border border-slate-200/70 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200/60" />
                                    <input id="addressPhone" type="tel" placeholder="Phone number"
                                        class="rounded-xl border border-slate-200/70 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200/60" />
                                    <input id="addressCity" type="text" placeholder="City"
                                        class="rounded-xl border border-slate-200/70 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200/60" />
                                    <input id="addressDistrict" type="text" placeholder="District"
                                        class="rounded-xl border border-slate-200/70 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200/60" />
                                    <input id="addressStreet" type="text" placeholder="Street"
                                        class="md:col-span-2 rounded-xl border border-slate-200/70 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200/60" />
                                </div>
                                <div class="mt-4 flex items-center justify-end gap-2">
                                    <button type="button" data-cancel-address
                                        class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                                        Cancel
                                    </button>
                                    <button type="button" data-save-address
                                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                                        Save address
                                    </button>
                                </div>
                            </div>

                            <div id="addressNotice"
                                class="hidden mt-3 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
                            </div>

                            <label class="mt-4 flex items-start gap-3 text-sm text-slate-700">
                                <input type="checkbox" class="mt-1 accent-[color:var(--primary)]">
                                <span>
                                    Someone else will receive the order?
                                    <span class="block text-xs text-slate-400 mt-1">
                                        If someone else will receive your order, the carrier will contact them on
                                        delivery.
                                    </span>
                                </span>
                            </label>

                            <x-button type="button" size="lg" variant="solid"
                                class="mt-5 w-full rounded-xl text-sm font-extrabold shadow-sm"
                                data-confirm-address>Confirm address</x-button>
                        </div>
                    </div>

                    <!-- SHIPPING COMPANIES (click to open) -->
                    <div class="mt-6 border-t border-slate-200/70 pt-5">
                        <button id="toggleShipping"
                            class="w-full p-6 flex items-center justify-between hover:bg-slate-50/70 transition"
                            type="button">
                            <div class="flex items-center gap-2 font-bold text-slate-900">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22"
                                    height="22" fill="none" class="text-slate-800">
                                    <circle cx="17" cy="18" r="2" stroke="currentColor"
                                        stroke-width="1.5"></circle>
                                    <circle cx="7" cy="18" r="2" stroke="currentColor"
                                        stroke-width="1.5"></circle>
                                    <path
                                        d="M5 17.9724C3.90328 17.9178 3.2191 17.7546 2.73223 17.2678C2.24536 16.7809 2.08222 16.0967 2.02755 15M9 18H15M19 17.9724C20.0967 17.9178 20.7809 17.7546 21.2678 17.2678C22 16.5355 22 15.357 22 13V11H17.3C16.5555 11 16.1832 11 15.882 10.9021C15.2731 10.7043 14.7957 10.2269 14.5979 9.61803C14.5 9.31677 14.5 8.94451 14.5 8.2C14.5 7.08323 14.5 6.52485 14.3532 6.07295C14.0564 5.15964 13.3404 4.44358 12.4271 4.14683C11.9752 4 11.4168 4 10.3 4H2"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path d="M2 8H8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path d="M2 11H6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path
                                        d="M14.5 6H16.3212C17.7766 6 18.5042 6 19.0964 6.35371C19.6886 6.70742 20.0336 7.34811 20.7236 8.6295L22 11"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                                <span>Shipping carrier</span>
                            </div>
                            <div id="shippingSummary" class="text-xs text-slate-500">SMSA | Express shipping, 2-3
                                business days</div>
                        </button>

                        <!-- shipping panel -->
                        <div id="shippingPanel"
                            class="hidden mt-4 rounded-xl border border-slate-200/70 bg-white shadow-sm p-4">
                            <ul id="shippingOptions" class="space-y-3">
                                <li class="shipping-option is-active rounded-md border border-slate-200/70 px-4 py-3 hover:bg-slate-50"
                                    data-shipping-summary="SMSA | Express shipping, 2-3 business days">
                                    <label class="flex items-center justify-between gap-3 cursor-pointer">
                                        <div class="flex items-center gap-3">
                                            <input type="radio" name="ship" checked
                                                class="accent-[color:var(--primary)]">
                                            <img class="h-8 w-8"
                                                src="https://cdn.assets.salla.network/prod/stores/images/shipping_logo.svg"
                                                alt="SMSA">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-semibold">SMSA | Express shipping</span>
                                                <span class="text-xs text-slate-500">2-3 business days</span>
                                            </div>
                                        </div>
                                        <div class="text-sm font-bold">12 <span class="text-slate-400">SAR</span>
                                        </div>
                                    </label>
                                </li>
                                <li class="shipping-option rounded-md border border-slate-200/70 px-4 py-3 hover:bg-slate-50"
                                    data-shipping-summary="Aramex | Standard shipping, 4-6 business days">
                                    <label class="flex items-center justify-between gap-3 cursor-pointer">
                                        <div class="flex items-center gap-3">
                                            <input type="radio" name="ship"
                                                class="accent-[color:var(--primary)]">
                                            <img class="h-8 w-8"
                                                src="https://cdn.assets.salla.network/prod/stores/images/shipping_logo.svg"
                                                alt="Aramex">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-semibold">Aramex | Standard shipping</span>
                                                <span class="text-xs text-slate-500">4-6 business days</span>
                                            </div>
                                        </div>
                                        <div class="text-sm font-bold">7 <span class="text-slate-400">SAR</span>
                                        </div>
                                    </label>
                                </li>
                            </ul>

                            <x-button type="button" size="lg" variant="solid"
                                class="mt-4 w-full rounded-xl text-sm font-extrabold shadow-sm" data-confirm-shipping>
                                Confirm carrier
                            </x-button>
                        </div>
                    </div>

                    <!-- PAYMENT (click to open) -->
                    <div class="mt-6 border-t border-slate-200/70 pt-5">
                        <button id="togglePayment"
                            class="w-full p-6 flex items-center justify-between hover:bg-slate-50/70 transition"
                            type="button">
                            <div class="flex items-center gap-2 font-bold text-slate-900">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22"
                                    height="22" fill="none" class="text-slate-800">
                                    <path
                                        d="M14.4998 12.001C14.4998 13.3817 13.3805 14.501 11.9998 14.501C10.6191 14.501 9.49982 13.3817 9.49982 12.001C9.49982 10.6203 10.6191 9.50098 11.9998 9.50098C13.3805 9.50098 14.4998 10.6203 14.4998 12.001Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path
                                        d="M16 5.00098C18.4794 5.00098 20.1903 5.38518 21.1329 5.6773C21.6756 5.84549 22 6.35987 22 6.92803V16.6833C22 17.7984 20.7719 18.6374 19.6762 18.4305C18.7361 18.253 17.5107 18.1104 16 18.1104C11.2491 18.1104 10.1096 19.9161 3.1448 18.3802C2.47265 18.232 2 17.6275 2 16.9392V6.92214C2 5.94628 2.92079 5.23464 3.87798 5.42458C10.1967 6.67844 11.4209 5.00098 16 5.00098Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path
                                        d="M2 9.00098C3.95133 9.00098 5.70483 7.40605 5.92901 5.75514M18.5005 5.50098C18.5005 7.54062 20.2655 9.46997 22 9.46997M22 15.001C20.1009 15.001 18.2601 16.3112 18.102 18.0993M6.00049 18.4971C6.00049 16.2879 4.20963 14.4971 2.00049 14.4971"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                                <span>Payment</span>
                            </div>
                            <div id="paymentSummary" class="text-xs text-slate-500">Mada</div>
                        </button>

                        <!-- payment panel -->
                        <div id="paymentPanel"
                            class="hidden mt-4 rounded-xl border border-slate-200/70 bg-white shadow-sm p-4">
                            <div class="relative" id="paymentDropdown">
                                <label class="text-xs font-semibold text-slate-500"
                                    for="paymentDropdownButton">Payment method</label>
                                <button id="paymentDropdownButton" type="button"
                                    class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200/60 flex items-center justify-between">
                                    <span class="flex items-center gap-2">
                                        <span id="paymentDropdownIcon"
                                            class="flex h-4 w-4 items-center justify-center text-slate-700"></span>
                                        <span id="paymentDropdownText"
                                            class="text-sm font-semibold text-slate-700">Mada</span>
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.17l3.71-3.94a.75.75 0 0 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div id="paymentDropdownMenu"
                                    class="absolute left-0 right-0 z-20 mt-2 hidden rounded-xl border border-slate-200 bg-white p-2 shadow-lg">
                                    <div class="max-h-64 space-y-1 overflow-auto">
                                        <button
                                            class="payment-option apple-pay-option hidden w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold shadow-sm hover:border-slate-300 hover:bg-slate-50 transition inline-flex items-center gap-2"
                                            type="button" aria-pressed="false" data-payment="apple-pay"
                                            data-label="Apple Pay">
                                            <svg viewBox="0 0 24 24" class="h-4 w-4 text-slate-800"
                                                fill="currentColor" aria-hidden="true">
                                                <path
                                                    d="M17.9 12.6c-.02-1.54 1.26-2.27 1.31-2.31-.72-1.06-1.84-1.2-2.24-1.22-.95-.1-1.86.56-2.34.56-.48 0-1.22-.55-2-.53-1.03.02-1.98.6-2.5 1.51-1.07 1.85-.27 4.57.77 6.07.5.73 1.1 1.56 1.89 1.53.76-.03 1.05-.49 1.97-.49.92 0 1.18.49 1.99.48.82-.02 1.34-.73 1.84-1.46.58-.84.82-1.65.83-1.69-.02-.01-1.6-.62-1.62-2.45Zm-1.53-4.23c.42-.5.7-1.2.62-1.9-.61.02-1.35.41-1.79.91-.39.45-.74 1.18-.65 1.87.68.05 1.38-.36 1.82-.88Z" />
                                            </svg>
                                            Apple Pay
                                        </button>
                                        <button
                                            class="payment-option google-pay-option hidden w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold shadow-sm hover:border-slate-300 hover:bg-slate-50 transition inline-flex items-center gap-2"
                                            type="button" aria-pressed="false" data-payment="google-pay"
                                            data-label="Google Pay">
                                            Google Pay
                                        </button>
                                        <button
                                            class="payment-option is-active w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold shadow-sm hover:border-slate-300 hover:bg-slate-50 transition inline-flex items-center gap-2"
                                            type="button" aria-pressed="true" data-payment="mada"
                                            data-label="Mada">
                                            <img class="h-4 w-auto"
                                                src="https://cdn.assets.salla.network/prod/stores/vendor/checkout/images/icons/pay-option-mada.svg"
                                                alt="mada">
                                            Mada
                                        </button>
                                        <button
                                            class="payment-option w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold shadow-sm hover:border-slate-300 hover:bg-slate-50 transition inline-flex items-center gap-2"
                                            type="button" aria-pressed="false" data-payment="credit"
                                            data-label="Card">
                                            <img class="h-4 w-auto"
                                                src="https://cdn.assets.salla.network/prod/stores/vendor/checkout/images/icons/pay-option-credit-2.svg"
                                                alt="credit">
                                            Card
                                        </button>
                                        <button
                                            class="payment-option w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold shadow-sm hover:border-slate-300 hover:bg-slate-50 transition inline-flex items-center gap-2"
                                            type="button" aria-pressed="false" data-payment="tabby"
                                            data-label="Tabby">
                                            <img class="h-4 w-auto"
                                                src="https://cdn.assets.salla.network/prod/stores/vendor/checkout/images/icons/pay-option-tabby_en.png?v=0.0.1"
                                                alt="tabby">
                                            Tabby
                                        </button>
                                        <button
                                            class="payment-option w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold shadow-sm hover:border-slate-300 hover:bg-slate-50 transition inline-flex items-center gap-2"
                                            type="button" aria-pressed="false" data-payment="tamara"
                                            data-label="Tamara">
                                            <img class="h-4 w-auto"
                                                src="https://cdn.assets.salla.network/prod/stores/vendor/checkout/images/icons/tamara/ar-tamara-label.svg"
                                                alt="tamara">
                                            Tamara
                                        </button>
                                        <button
                                            class="payment-option w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold shadow-sm hover:border-slate-300 hover:bg-slate-50 transition"
                                            type="button" aria-pressed="false" data-payment="bank-transfer"
                                            data-label="Bank transfer">
                                            Bank transfer
                                        </button>
                                        <button
                                            class="payment-option w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold shadow-sm hover:border-slate-300 hover:bg-slate-50 transition inline-flex items-center justify-between gap-2"
                                            type="button" aria-pressed="false" data-payment="cod"
                                            data-label="Cash on delivery">
                                            Cash on delivery
                                            <span
                                                class="rounded-full bg-sky-100 text-sky-700 text-[11px] px-2 py-0.5 border border-sky-200">+10
                                                SAR</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div data-payment-panel="card">
                                <div class="mt-4 rounded-2xl border border-slate-200/70 bg-white p-4 shadow-sm">
                                    <div class="grid gap-4 md:grid-cols-3">
                                        <div class="md:col-span-2">
                                            <label class="text-sm font-semibold text-slate-700"
                                                for="Field-numberInput">Card number</label>
                                            <div class="mt-2 relative">
                                                <input dir="ltr" type="text" inputmode="numeric"
                                                    name="number" id="Field-numberInput"
                                                    placeholder="1234 1234 1234 1234" autocomplete="cc-number"
                                                    aria-invalid="false"
                                                    aria-describedby="cardBrandIconsDesc cardNumberError"
                                                    aria-required="true"
                                                    class="w-full rounded-xl border border-slate-200/70 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200/60 pr-28">
                                                <div
                                                    class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-2 text-slate-500">
                                                    <span id="cardBrandBadge"
                                                        class="hidden rounded-md bg-slate-900 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-white"></span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="28"
                                                        height="18" viewBox="0 0 28 18" fill="none"
                                                        class="h-4 w-auto" aria-hidden="true">
                                                        <rect x="1" y="1" width="26" height="16"
                                                            rx="3" fill="#0f172a" />
                                                        <rect x="3" y="4" width="8" height="4"
                                                            rx="1" fill="#e2e8f0" />
                                                        <rect x="3" y="11" width="10" height="2"
                                                            rx="1" fill="#94a3b8" />
                                                        <circle cx="18" cy="9" r="4" fill="#f59e0b" />
                                                        <circle cx="22" cy="9" r="4" fill="#ef4444"
                                                            fill-opacity="0.9" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div id="cardBrandIconsDesc" class="mt-2 text-xs text-slate-500">
                                                Supported cards include Visa and Mastercard.
                                            </div>
                                            <div id="cardNumberError" class="mt-2 hidden text-xs text-red-600">Your
                                                card number is invalid.</div>
                                        </div>

                                    </div>
                                    <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-2 grid-cols-2">
                                        <div>
                                            <div class="rounded-2xl bg-slate-50 px-4 py-2">
                                                <label class="text-xs font-semibold text-slate-500"
                                                    for="Field-expiryInput">Expiration (MM/YY)</label>
                                                <input dir="ltr" type="text" inputmode="numeric"
                                                    name="expiry" id="Field-expiryInput" placeholder="MM / YY"
                                                    autocomplete="cc-exp" aria-invalid="false" aria-required="true"
                                                    class="mt-1 w-full bg-transparent text-sm font-semibold text-slate-700 placeholder:text-slate-400 focus:outline-none">
                                            </div>
                                            <div id="expiryError" class="mt-2 hidden text-xs text-red-600">Expiration
                                                date is in the past.</div>
                                        </div>

                                        <div>
                                            <div class="rounded-xl bg-slate-50 px-4 py-2">
                                                <label class="text-xs font-semibold text-slate-500"
                                                    for="Field-cvcInput">Security code</label>
                                                <div class="mt-1 relative">
                                                    <input dir="ltr" type="text" inputmode="numeric"
                                                        name="cvc" id="Field-cvcInput" placeholder="CVC"
                                                        autocomplete="cc-csc" aria-invalid="false"
                                                        aria-describedby="cvcDesc" aria-required="true"
                                                        class="w-full bg-transparent text-sm font-semibold text-slate-700 placeholder:text-slate-400 focus:outline-none pr-10">
                                                    <div
                                                        class="absolute right-0 top-1/2 -translate-y-1/2 text-slate-500">
                                                        <svg class="h-4 w-auto" width="30" height="20"
                                                            viewBox="0 0 30 20" xmlns="http://www.w3.org/2000/svg"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path opacity="0.74"
                                                                d="M25.2061 0.00488281C27.3194 0.112115 29 1.85996 29 4V11.3291C28.5428 11.0304 28.0336 10.8304 27.5 10.7188V8H1.5V16C1.5 17.3807 2.61929 18.5 4 18.5H10.1104V20H4L3.79395 19.9951C1.7488 19.8913 0.108652 18.2512 0.00488281 16.2061L0 16V4C0 1.85996 1.68056 0.112115 3.79395 0.00488281L4 0H25L25.2061 0.00488281ZM4 1.5C2.61929 1.5 1.5 2.61929 1.5 4V5H27.5V4C27.5 2.61929 26.3807 1.5 25 1.5H4Z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="cvcDesc" class="mt-2 text-xs text-slate-500">3-digit code on
                                                back of card</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div data-payment-panel="tabby" class="hidden mt-5 space-y-4">
                                <div
                                    class="rounded-xl border border-slate-200/70 bg-slate-50/60 p-4 text-sm text-slate-600">
                                    Split your payment with Tabby. Enter your mobile number to continue.
                                </div>
                                <x-input placeholder="Mobile number"
                                    class="rounded-xl border border-slate-200/70 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200/60" />
                                <x-button type="button" size="lg" variant="solid"
                                    class="w-full rounded-xl text-sm font-extrabold shadow-sm">
                                    Continue with Tabby
                                </x-button>
                            </div>

                            <div data-payment-panel="tamara" class="hidden mt-5 space-y-4">
                                <div
                                    class="rounded-xl border border-slate-200/70 bg-slate-50/60 p-4 text-sm text-slate-600">
                                    Tamara requires a national ID to verify your account.
                                </div>
                                <x-input placeholder="National ID"
                                    class="rounded-xl border border-slate-200/70 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200/60" />
                                <x-button type="button" size="lg" variant="solid"
                                    class="w-full rounded-xl text-sm font-extrabold shadow-sm">
                                    Continue with Tamara
                                </x-button>
                            </div>

                            <div data-payment-panel="apple-pay" class="hidden mt-5 space-y-4">
                                <div
                                    class="rounded-xl border border-slate-200/70 bg-slate-50/60 p-4 text-sm text-slate-600">
                                    Apple Pay is available on iOS devices. Continue to authorize with Apple Pay.
                                </div>
                                <x-button type="button" size="lg" variant="solid"
                                    class="w-full rounded-xl text-sm font-extrabold shadow-sm">
                                    Pay with Apple Pay
                                </x-button>
                            </div>

                            <div data-payment-panel="google-pay" class="hidden mt-5 space-y-4">
                                <div
                                    class="rounded-xl border border-slate-200/70 bg-slate-50/60 p-4 text-sm text-slate-600">
                                    Google Pay is available on Android devices. Continue to authorize with Google Pay.
                                </div>
                                <x-button type="button" size="lg" variant="solid"
                                    class="w-full rounded-xl text-sm font-extrabold shadow-sm">
                                    Pay with Google Pay
                                </x-button>
                            </div>

                            <div data-payment-panel="bank-transfer" class="hidden mt-5 space-y-4">
                                <div
                                    class="rounded-xl border border-slate-200/70 bg-slate-50/60 p-4 text-sm text-slate-600">
                                    Transfer to: SA00 0000 0000 0000 0000 0000 (Rukn Bank). Upload your receipt.
                                </div>
                                <input type="file"
                                    class="w-full rounded-xl border border-slate-200/70 bg-white px-4 py-3 text-sm shadow-sm file:mr-4 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200" />
                                <x-button type="button" size="lg" variant="solid"
                                    class="w-full rounded-xl text-sm font-extrabold shadow-sm">
                                    Submit transfer
                                </x-button>
                            </div>

                            <div data-payment-panel="cod" class="hidden mt-5 space-y-4">
                                <div
                                    class="rounded-xl border border-slate-200/70 bg-slate-50/60 p-4 text-sm text-slate-600">
                                    Pay in cash upon delivery. Add delivery instructions if needed.
                                </div>
                                <textarea rows="3"
                                    class="w-full rounded-xl border border-slate-200/70 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200/60"
                                    placeholder="Delivery instructions"></textarea>
                                <x-button type="button" size="lg" variant="solid"
                                    class="w-full rounded-xl text-sm font-extrabold shadow-sm">
                                    Confirm cash on delivery
                                </x-button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-200/70 px-6 pb-6 pt-6">
                    <x-button id="openPlaceOrder" type="button" size="lg" variant="solid"
                        class="w-full rounded-xl text-sm font-extrabold shadow-sm">
                        Place order
                    </x-button>
                </div>
            </x-card>

            <!-- bottom text -->
            <div class="mt-10 text-center text-sm text-slate-500 leading-7">
                Every order gives back.<br>
                We donate a portion of your order to the Rukn Al-Hiwar charity.
            </div>
        </div>
    </main>

    <!-- ===================== PLACE ORDER MODAL ===================== -->
    <div id="placeOrderModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/40" data-close-place-order></div>
        <div class="relative mx-auto flex min-h-screen max-w-lg items-center px-4">
            <form id="placeOrderForm" action="/orders/place" method="post"
                class="w-full rounded-2xl bg-white p-6 shadow-xl">
                @csrf
                <input type="hidden" name="redirect" value="/orders/success">
                <h3 class="text-lg font-bold text-slate-900">Place order?</h3>
                <p class="mt-2 text-sm text-slate-600">
                    We'll submit your order and redirect to the confirmation page.
                </p>
                <div class="mt-6 flex items-center justify-end gap-2">
                    <button type="button" data-close-place-order
                        class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                        Cancel
                    </button>
                    <x-button type="submit" size="md" variant="solid"
                        class="rounded-lg px-5 py-2 text-sm font-semibold">
                        Place order
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===================== ORDER DETAILS DRAWER ===================== -->
    <div id="drawerOverlay" class="fixed inset-0 z-50 hidden">
        <!-- backdrop -->
        <div class="absolute inset-0 bg-black/40" data-close-drawer></div>

        <!-- drawer -->
        <aside id="drawer"
            class="absolute left-0 top-0 h-full w-full max-w-md bg-white shadow-[var(--shadow)]
                translate-x-[-100%] transition-transform duration-300 bg-white">
            <div class="cart-drawer-cont h-full flex flex-col">
                <div
                    class="cart-drawer__header flex items-center justify-between border-b border-[color:var(--line)] px-5 py-4">
                    <h3 class="cart-drawer__title text-base font-extrabold">Order details</h3>
                    <button id="closeDrawer" class="cart-drawer__close text-slate-500 hover:text-slate-900"
                        aria-label="close" type="button">
                        ×
                    </button>
                </div>

                <div class="cart-drawer__content flex-1 overflow-hidden">
                        <div class="cart-drawer__items h-full">
                            <div class="cart-drawer__scroll-content h-full overflow-auto p-5 space-y-4">
                                @forelse ($cartItems as $item)
                                    <div class="cart-item flex gap-3">
                                        <div
                                            class="cart-item__image relative h-14 w-14 overflow-hidden rounded-xl border border-[color:var(--line)] bg-white">
                                            <img class="h-full w-full object-cover" src="{{ $item['image'] ?? '' }}"
                                                alt="{{ $item['name'] }}">
                                            <div
                                                class="cart-item__quantity-badge absolute -right-2 -top-2 grid h-6 w-6 place-items-center rounded-full bg-[color:var(--primary)] text-xs font-bold text-white">
                                                {{ $item['qty'] }}</div>
                                        </div>
                                        <div class="cart-item__details flex-1">
                                            <div class="cart-item__info">
                                                <h4 class="cart-item__name text-sm font-semibold leading-6">
                                                    {{ $item['name'] }}
                                                </h4>
                                                <div class="cart-item__meta text-xs text-slate-400 mt-1">
                                                    <span class="cart-item__specs"></span>
                                                </div>
                                            </div>
                                            <div class="cart-item__bottom mt-2">
                                                <div class="cart-item__price text-sm font-bold">
                                                    {{ number_format($item['price'], 2) }} <small
                                                        class="cart-item__currency text-slate-400">SAR</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-sm text-slate-500">No items in your cart.</div>
                                @endforelse

                        </div>
                    </div>
                </div>

                <!-- footer summary -->
                <div class="border-t border-[color:var(--line)] p-5 space-y-4">
                    <div class="flex items-center justify-between text-lg">
                        <span class="font-semibold text-slate-700">Subtotal</span>
                        <span class="font-bold text-2xl text-blue-600">
                            {{ number_format($totals['subtotal'] ?? 0, 2) }} <span
                                class="text-slate-400">SAR</span></span>
                    </div>
                    <x-button type="button" size="lg" variant="solid" class="w-full rounded-md">Continue
                        checkout</x-button>
                </div>
            </div>
        </aside>
    </div>

    @push('scripts')
        <script>
            const overlay = document.getElementById('drawerOverlay');
            const drawer = document.getElementById('drawer');
            const openBtn = document.getElementById('openOrderDetails');
            const closeBtn = document.getElementById('closeDrawer');
            const alertBox = document.getElementById('applePayAlert');
            const copyBtn = document.getElementById('copyCheckoutLink');
            const openPlaceOrderBtn = document.getElementById('openPlaceOrder');
            const placeOrderModal = document.getElementById('placeOrderModal');
            const placeOrderForm = document.getElementById('placeOrderForm');
            const closePlaceOrderBtns = document.querySelectorAll('[data-close-place-order]');

            function openDrawer() {
                if (!overlay || !drawer) return;
                overlay.classList.remove('hidden');
                requestAnimationFrame(() => drawer.classList.remove('translate-x-[-100%]'));
                document.body.style.overflow = 'hidden';
            }

            function closeDrawer() {
                if (!overlay || !drawer) return;
                drawer.classList.add('translate-x-[-100%]');
                setTimeout(() => overlay.classList.add('hidden'), 250);
                document.body.style.overflow = '';
            }

            openBtn?.addEventListener('click', openDrawer);
            closeBtn?.addEventListener('click', closeDrawer);
            overlay?.addEventListener('click', (e) => {
                if (e.target.hasAttribute('data-close-drawer')) closeDrawer();
            });

            function openPlaceOrderModal() {
                if (!placeOrderModal) return;
                placeOrderModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closePlaceOrderModal() {
                if (!placeOrderModal) return;
                placeOrderModal.classList.add('hidden');
                document.body.style.overflow = '';
            }

            openPlaceOrderBtn?.addEventListener('click', openPlaceOrderModal);
            closePlaceOrderBtns.forEach((btn) => {
                btn.addEventListener('click', closePlaceOrderModal);
            });

            placeOrderForm?.addEventListener('submit', () => {
                closePlaceOrderModal();
            });

            alertBox?.addEventListener('click', (e) => {
                if (e.target && e.target.hasAttribute('data-dismiss-alert')) {
                    alertBox.classList.add('hidden');
                }
            });

            copyBtn?.addEventListener('click', async () => {
                const url = window.location.href;
                try {
                    await navigator.clipboard.writeText(url);
                } catch (err) {
                    const temp = document.createElement('input');
                    temp.value = url;
                    document.body.appendChild(temp);
                    temp.select();
                    document.execCommand('copy');
                    temp.remove();
                }
            });

            const shippingBtn = document.getElementById('toggleShipping');
            const shippingPanel = document.getElementById('shippingPanel');
            const payBtn = document.getElementById('togglePayment');
            const payPanel = document.getElementById('paymentPanel');
            const paymentOptions = document.querySelectorAll('.payment-option');
            const paymentPanels = document.querySelectorAll('[data-payment-panel]');
            const applePayOption = document.querySelector('.apple-pay-option');
            const applePayPanel = document.querySelector('[data-payment-panel="apple-pay"]');
            const googlePayOption = document.querySelector('.google-pay-option');
            const googlePayPanel = document.querySelector('[data-payment-panel="google-pay"]');
            const paymentDropdownButton = document.getElementById('paymentDropdownButton');
            const paymentDropdownMenu = document.getElementById('paymentDropdownMenu');
            const paymentDropdownText = document.getElementById('paymentDropdownText');
            const paymentDropdownIcon = document.getElementById('paymentDropdownIcon');
            const addressList = document.getElementById('addressList');
            const addAddressBtn = document.querySelector('[data-add-address]');
            const addressDialog = document.getElementById('addressDialog');
            const cancelAddressBtn = document.querySelector('[data-cancel-address]');
            const saveAddressBtn = document.querySelector('[data-save-address]');
            const addressName = document.getElementById('addressName');
            const addressPhone = document.getElementById('addressPhone');
            const addressCity = document.getElementById('addressCity');
            const addressDistrict = document.getElementById('addressDistrict');
            const addressStreet = document.getElementById('addressStreet');
            const addressNotice = document.getElementById('addressNotice');
            const confirmAddressBtn = document.querySelector('[data-confirm-address]');
            const addressSummary = document.getElementById('selectedAddressSummary');
            const shippingOptions = document.querySelectorAll('.shipping-option');
            const confirmShippingBtn = document.querySelector('[data-confirm-shipping]');
            const shippingSummary = document.getElementById('shippingSummary');
            const paymentSummary = document.getElementById('paymentSummary');
            const expiryInput = document.getElementById('Field-expiryInput');
            const expiryError = document.getElementById('expiryError');
            const cardNumberInput = document.getElementById('Field-numberInput');
            const cardBrandBadge = document.getElementById('cardBrandBadge');
            const cardNumberError = document.getElementById('cardNumberError');
            const cvcInput = document.getElementById('Field-cvcInput');
            let currentCardBrand = '';

            shippingBtn?.addEventListener('click', () => {
                shippingPanel?.classList.toggle('hidden');
            });
            payBtn?.addEventListener('click', () => {
                payPanel?.classList.toggle('hidden');
            });

            const paymentPanelMap = {
                'apple-pay': 'apple-pay',
                'google-pay': 'google-pay',
                mada: 'card',
                credit: 'card',
                tabby: 'tabby',
                tamara: 'tamara',
                'bank-transfer': 'bank-transfer',
                cod: 'cod',
            };

            function showPaymentPanel(method) {
                const target = paymentPanelMap[method] || 'card';
                paymentPanels.forEach((panel) => {
                    if (panel.getAttribute('data-payment-panel') === target) {
                        panel.classList.remove('hidden');
                    } else {
                        panel.classList.add('hidden');
                    }
                });
            }

            const updatePaymentDropdown = (option) => {
                if (!option || !paymentDropdownText) return;
                const label = option.getAttribute('data-label') || option.textContent?.trim();
                if (label) paymentDropdownText.textContent = label;
                if (paymentDropdownIcon) {
                    paymentDropdownIcon.innerHTML = '';
                    const icon = option.querySelector('img, svg');
                    if (icon) {
                        const clone = icon.cloneNode(true);
                        if (clone.tagName === 'IMG') {
                            clone.className = 'h-4 w-auto';
                        } else {
                            clone.className = 'h-4 w-4';
                        }
                        paymentDropdownIcon.appendChild(clone);
                    }
                }
            };

            const closePaymentDropdown = () => {
                paymentDropdownMenu?.classList.add('hidden');
            };

            paymentDropdownButton?.addEventListener('click', (e) => {
                e.preventDefault();
                paymentDropdownMenu?.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!paymentDropdownMenu || !paymentDropdownButton) return;
                if (!paymentDropdownMenu.contains(e.target) && !paymentDropdownButton.contains(e.target)) {
                    closePaymentDropdown();
                }
            });

            paymentOptions.forEach((option) => {
                option.addEventListener('click', () => {
                    paymentOptions.forEach((btn) => {
                        btn.classList.remove('is-active');
                        btn.setAttribute('aria-pressed', 'false');
                    });
                    option.classList.add('is-active');
                    option.setAttribute('aria-pressed', 'true');
                    if (payPanel?.classList.contains('hidden')) {
                        payPanel.classList.remove('hidden');
                    }
                    const label = option.getAttribute('data-label');
                    if (label && paymentSummary) paymentSummary.textContent = label;
                    showPaymentPanel(option.getAttribute('data-payment'));
                    updatePaymentDropdown(option);
                    closePaymentDropdown();
                });
            });

            expiryInput?.addEventListener('input', (e) => {
                const input = e.target;
                let value = input.value.replace(/\D/g, '').slice(0, 4);
                if (value.length === 1 && value !== '0' && Number(value) >= 2) {
                    value = `0${value}`;
                }
                if (value.length >= 3) {
                    value = `${value.slice(0, 2)} / ${value.slice(2)}`;
                } else if (value.length >= 2) {
                    value = `${value.slice(0, 2)} / `;
                }
                input.value = value;

                const digits = input.value.replace(/\D/g, '');
                const month = Number(digits.slice(0, 2));
                const year = Number(digits.slice(2, 4));
                const isMonthInvalid = digits.length >= 2 && (month < 1 || month > 12);

                if (expiryError) {
                    if (isMonthInvalid) {
                        expiryError.textContent = 'Month must be between 01 and 12.';
                        expiryError.classList.remove('hidden');
                        input.setAttribute('aria-invalid', 'true');
                        return;
                    }
                    expiryError.textContent = 'Expiration date is in the past.';
                }

                if (digits.length === 4) {
                    const now = new Date();
                    const currentYear = Number(String(now.getFullYear()).slice(-2));
                    const currentMonth = now.getMonth() + 1;
                    const isPast = year < currentYear || (year === currentYear && month < currentMonth);
                    if (expiryError) {
                        expiryError.classList.toggle('hidden', !isPast);
                    }
                    input.setAttribute('aria-invalid', String(isPast));
                } else if (expiryError) {
                    expiryError.classList.add('hidden');
                    input.setAttribute('aria-invalid', 'false');
                }
            });

            function luhnCheck(number) {
                let sum = 0;
                let shouldDouble = false;
                for (let i = number.length - 1; i >= 0; i -= 1) {
                    let digit = Number(number[i]);
                    if (shouldDouble) {
                        digit *= 2;
                        if (digit > 9) digit -= 9;
                    }
                    sum += digit;
                    shouldDouble = !shouldDouble;
                }
                return sum % 10 === 0;
            }

            function detectCardBrand(digits) {
                if (/^4/.test(digits)) return 'visa';
                if (/^(5[1-5])/.test(digits) || /^(222[1-9]|22[3-9]\\d|2[3-6]\\d{2}|27[01]\\d|2720)/.test(digits))
                    return 'mastercard';
                if (/^3[47]/.test(digits)) return 'amex';
                if (/^6(011|5|4[4-9])/.test(digits)) return 'discover';
                if (/^35(2[8-9]|[3-8]\\d)/.test(digits)) return 'jcb';
                return '';
            }

            function updateBrandBadge(brand) {
                if (!cardBrandBadge) return;
                if (!brand) {
                    cardBrandBadge.classList.add('hidden');
                    cardBrandBadge.textContent = '';
                    return;
                }
                const labels = {
                    visa: 'Visa',
                    mastercard: 'MC',
                    amex: 'Amex',
                    discover: 'Discover',
                    jcb: 'JCB',
                };
                cardBrandBadge.textContent = labels[brand] || brand;
                cardBrandBadge.classList.remove('hidden');
                cardBrandBadge.classList.toggle('bg-blue-600', brand === 'visa');
                cardBrandBadge.classList.toggle('bg-black', brand === 'mastercard');
                cardBrandBadge.classList.toggle('bg-sky-600', brand === 'amex');
                cardBrandBadge.classList.toggle('bg-amber-500', brand === 'discover');
                cardBrandBadge.classList.toggle('bg-emerald-600', brand === 'jcb');
            }

            function updateCvcRules(brand) {
                if (!cvcInput) return;
                const isAmex = brand === 'amex';
                cvcInput.maxLength = isAmex ? 4 : 3;
                cvcInput.placeholder = isAmex ? '4-digit CVC' : 'CVC';
            }

            cardNumberInput?.addEventListener('input', (e) => {
                const input = e.target;
                const digits = input.value.replace(/\D/g, '').slice(0, 19);
                const parts = digits.match(/.{1,4}/g) || [];
                input.value = parts.join(' ');

                const brand = detectCardBrand(digits);
                updateBrandBadge(brand);
                currentCardBrand = brand;
                updateCvcRules(brand);

                let isInvalid = false;
                if (digits.length >= 13) {
                    isInvalid = !luhnCheck(digits);
                }
                if (cardNumberError) {
                    cardNumberError.classList.toggle('hidden', !isInvalid);
                }
                input.setAttribute('aria-invalid', String(isInvalid));
                input.classList.toggle('border-red-500', isInvalid);
                input.classList.toggle('text-red-600', isInvalid);
            });

            cvcInput?.addEventListener('input', (e) => {
                const input = e.target;
                const digits = input.value.replace(/\D/g, '');
                const maxLen = currentCardBrand === 'amex' ? 4 : 3;
                input.value = digits.slice(0, maxLen);
            });

            function updateAddressActive() {
                const selected = addressList?.querySelector('input[name=\"address\"]:checked');
                addressList?.querySelectorAll('.address-item').forEach((item) => {
                    item.classList.toggle('is-active', item.contains(selected));
                });
            }

            addressList?.addEventListener('change', (e) => {
                if (e.target && e.target.matches('input[name=\"address\"]')) {
                    updateAddressActive();
                }
            });

            const ua = navigator.userAgent || '';
            const isIOS = /iPhone|iPad|iPod/.test(ua) || (/Macintosh/.test(ua) && 'ontouchend' in document);
            const isAndroid = /Android/.test(ua);
            const isSafari = /Safari/.test(ua) && !/Chrome|CriOS|FxiOS|EdgiOS|OPiOS/.test(ua);
            if (isIOS && isSafari) {
                alertBox?.classList.remove('hidden');
            }

            const isApplePayAvailable = isIOS && isSafari;
            const isGooglePayAvailable = isAndroid;

            const applyPlatformPaymentOptions = () => {
                if (applePayOption) {
                    applePayOption.classList.toggle('hidden', !isApplePayAvailable);
                    applePayOption.style.display = isApplePayAvailable ? '' : 'none';
                }
                if (googlePayOption) {
                    googlePayOption.classList.toggle('hidden', !isGooglePayAvailable);
                    googlePayOption.style.display = isGooglePayAvailable ? '' : 'none';
                }

                if (!isApplePayAvailable) {
                    applePayPanel?.classList.add('hidden');
                    if (applePayOption?.classList.contains('is-active')) {
                        applePayOption.classList.remove('is-active');
                        applePayOption.setAttribute('aria-pressed', 'false');
                        const fallback = document.querySelector('.payment-option[data-payment="mada"]');
                        fallback?.classList.add('is-active');
                        fallback?.setAttribute('aria-pressed', 'true');
                        showPaymentPanel('mada');
                        if (paymentSummary) paymentSummary.textContent = 'Mada';
                        updatePaymentDropdown(fallback);
                    }
                }

                if (!isGooglePayAvailable) {
                    googlePayPanel?.classList.add('hidden');
                    if (googlePayOption?.classList.contains('is-active')) {
                        const fallback = document.querySelector('.payment-option[data-payment="mada"]');
                        fallback?.classList.add('is-active');
                        fallback?.setAttribute('aria-pressed', 'true');
                        showPaymentPanel('mada');
                        if (paymentSummary) paymentSummary.textContent = 'Mada';
                        updatePaymentDropdown(fallback);
                    }
                }
            };

            applyPlatformPaymentOptions();

            addressList?.addEventListener('click', (e) => {
                const editBtn = e.target.closest('[data-edit-address]');
                const deleteBtn = e.target.closest('[data-delete-address]');
                if (editBtn) {
                    e.preventDefault();
                    const item = editBtn.closest('[data-address]');
                    const current = item?.getAttribute('data-address') || '';
                    if (item) {
                        editingAddressItem = item;
                        setAddressDialogFromText(current);
                        addressDialog?.classList.remove('hidden');
                        addressDialog?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest'
                        });
                    }
                }
                if (deleteBtn) {
                    e.preventDefault();
                    const item = deleteBtn.closest('[data-address]');
                    const wasSelected = item?.querySelector('input[name=\"address\"]')?.checked;
                    item?.remove();
                    if (wasSelected) {
                        const first = addressList?.querySelector('input[name=\"address\"]');
                        if (first) first.checked = true;
                    }
                    updateAddressActive();
                }
            });

            function resetAddressDialog() {
                if (addressName) addressName.value = '';
                if (addressPhone) addressPhone.value = '';
                if (addressCity) addressCity.value = '';
                if (addressDistrict) addressDistrict.value = '';
                if (addressStreet) addressStreet.value = '';
            }

            let editingAddressItem = null;

            function setAddressDialogFromText(text) {
                const parts = (text || '').split(' - ').map((part) => part.trim());
                if (addressName) addressName.value = parts[0] || '';
                if (addressPhone) addressPhone.value = parts[1] || '';
                if (addressCity) addressCity.value = parts[2] || '';
                if (addressDistrict) addressDistrict.value = parts[3] || '';
                if (addressStreet) addressStreet.value = parts[4] || '';
            }

            function buildAddressText() {
                const parts = [
                    addressName?.value?.trim(),
                    addressPhone?.value?.trim(),
                    addressCity?.value?.trim(),
                    addressDistrict?.value?.trim(),
                    addressStreet?.value?.trim(),
                ].filter(Boolean);
                return parts.join(' - ');
            }

            addAddressBtn?.addEventListener('click', () => {
                editingAddressItem = null;
                resetAddressDialog();
                addressDialog?.classList.remove('hidden');
                addressDialog?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            });

            cancelAddressBtn?.addEventListener('click', () => {
                editingAddressItem = null;
                addressDialog?.classList.add('hidden');
            });

            saveAddressBtn?.addEventListener('click', () => {
                const value = buildAddressText();
                if (!value || !addressList) return;

                if (editingAddressItem) {
                    editingAddressItem.setAttribute('data-address', value);
                    const textEl = editingAddressItem.querySelector('[data-address-text]');
                    if (textEl) textEl.textContent = value;
                    editingAddressItem = null;
                    addressDialog?.classList.add('hidden');
                    updateAddressActive();
                    if (addressNotice) {
                        addressNotice.textContent = 'Address updated successfully.';
                        addressNotice.classList.remove('hidden');
                        setTimeout(() => addressNotice.classList.add('hidden'), 2500);
                    }
                    return;
                }

                const label = document.createElement('label');
                label.className =
                    'address-item flex items-start justify-between gap-3 rounded-lg border border-slate-200/70 p-3';
                label.setAttribute('data-address', value);

                const left = document.createElement('div');
                left.className = 'flex items-start gap-3';
                const radio = document.createElement('input');
                radio.type = 'radio';
                radio.name = 'address';
                radio.className = 'mt-1 accent-[color:var(--primary)]';
                radio.checked = true;
                const text = document.createElement('span');
                text.className = 'text-sm text-slate-700';
                text.setAttribute('data-address-text', '');
                text.textContent = value;
                left.appendChild(radio);
                left.appendChild(text);

                const actions = document.createElement('div');
                actions.className = 'flex items-center gap-3';
                actions.innerHTML = `
                    <button class="text-slate-500 hover:text-slate-800" aria-label="edit" data-edit-address type="button">
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7">
                            <path d="M12 20h9" />
                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                        </svg>
                    </button>
                    <button class="text-red-500 hover:text-red-600" aria-label="delete" data-delete-address type="button">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7">
                            <path d="M3 6h18" />
                            <path d="M8 6V4h8v2" />
                            <path d="M19 6l-1 16H6L5 6" />
                            <path d="M10 11v6M14 11v6" />
                        </svg>
                    </button>
                `;

                label.appendChild(left);
                label.appendChild(actions);
                addressList.prepend(label);
                addressDialog?.classList.add('hidden');
                updateAddressActive();
                if (addressNotice) {
                    addressNotice.textContent = 'Address saved successfully.';
                    addressNotice.classList.remove('hidden');
                    setTimeout(() => addressNotice.classList.add('hidden'), 2500);
                }
            });

            confirmAddressBtn?.addEventListener('click', () => {
                const selected = addressList?.querySelector('input[name=\"address\"]:checked');
                const item = selected?.closest('[data-address]');
                const text = item?.getAttribute('data-address');
                if (text && addressSummary) addressSummary.textContent = text;
            });

            shippingOptions.forEach((option) => {
                option.addEventListener('click', () => {
                    shippingOptions.forEach((item) => item.classList.remove('is-active'));
                    option.classList.add('is-active');
                    const radio = option.querySelector('input[name=\"ship\"]');
                    if (radio) radio.checked = true;
                });
            });

            confirmShippingBtn?.addEventListener('click', () => {
                const active = document.querySelector('.shipping-option.is-active');
                const text = active?.getAttribute('data-shipping-summary');
                if (text && shippingSummary) shippingSummary.textContent = text;
            });

            const initialOption = document.querySelector('.payment-option.is-active');
            const initialPayment = initialOption?.getAttribute('data-payment');
            showPaymentPanel(initialPayment);
            if (initialOption) {
                updatePaymentDropdown(initialOption);
                const label = initialOption.getAttribute('data-label');
                if (label && paymentSummary) paymentSummary.textContent = label;
            }
        </script>
    @endpush
</x-layouts.app>
