@php
    $siteContent = $siteContent ?? app(\App\Services\SiteContent::class);
    $footerConfig = $siteContent->footer();
    $company = $footerConfig['company'] ?? [];
    $links = $footerConfig['links'] ?? [];
    $contacts = $footerConfig['contact'] ?? [];
    $payments = $footerConfig['payments'] ?? [];
    $copyrightText = $footerConfig['copyright'] ?? 'Otex E-Commerce © ' . now()->year;
    $contactIconPaths = [
        'whatsapp' => 'M27.281 4.65c-2.994-3-6.975-4.65-11.219-4.65-8.738 0-15.85 7.112-15.85 15.856 0 2.794 0.731 5.525 2.119 7.925l-2.25 8.219 8.406-2.206c2.319 1.262 4.925 1.931 7.575 1.931h0.006c0 0 0 0 0 0 8.738 0 15.856-7.113 15.856-15.856 0-4.238-1.65-8.219-4.644-11.219zM16.069 29.050v0c-2.369 0-4.688-0.637-6.713-1.837l-0.481-0.288-4.987 1.306 1.331-4.863-0.313-0.5c-1.325-2.094-2.019-4.519-2.019-7.012 0-7.269 5.912-13.181 13.188-13.181 3.519 0 6.831 1.375 9.319 3.862 2.488 2.494 3.856 5.8 3.856 9.325-0.006 7.275-5.919 13.188-13.181 13.188zM23.294 19.175c-0.394-0.2-2.344-1.156-2.706-1.288s-0.625-0.2-0.894 0.2c-0.262 0.394-1.025 1.288-1.256 1.556-0.231 0.262-0.462 0.3-0.856 0.1s-1.675-0.619-3.188-1.969c-1.175-1.050-1.975-2.35-2.206-2.744s-0.025-0.613 0.175-0.806c0.181-0.175 0.394-0.463 0.594-0.694s0.262-0.394 0.394-0.662c0.131-0.262 0.069-0.494-0.031-0.694s-0.894-2.15-1.219-2.944c-0.319-0.775-0.65-0.669-0.894-0.681-0.231-0.012-0.494-0.012-0.756-0.012s-0.694 0.1-1.056 0.494c-0.363 0.394-1.387 1.356-1.387 3.306s1.419 3.831 1.619 4.1c0.2 0.262 2.794 4.269 6.769 5.981 0.944 0.406 1.681 0.65 2.256 0.837 0.95 0.3 1.813 0.256 2.494 0.156 0.762-0.113 2.344-0.956 2.675-1.881s0.331-1.719 0.231-1.881c-0.094-0.175-0.356-0.275-0.756-0.475z',
        'phone' => 'M30.823 21.713l-3.883-3.883c-1.569-1.568-4.12-1.568-5.689 0l-2.568 2.568c-3.063-1.499-5.583-4.019-7.081-7.083l2.568-2.567c0.759-0.76 1.177-1.771 1.177-2.845s-0.419-2.084-1.179-2.844l-3.881-3.881c-1.52-1.521-4.171-1.521-5.689 0l-1.845 1.847c-2.22 2.219-3.183 5.407-2.573 8.527 1.98 10.144 10.125 18.292 20.269 20.271 0.616 0.121 1.236 0.18 1.849 0.18 2.492 0 4.896-0.972 6.677-2.752l1.847-1.847c1.568-1.571 1.568-4.121 0.001-5.691zM28.936 25.517l-1.845 1.847c-1.592 1.592-3.883 2.283-6.132 1.841-9.089-1.776-16.388-9.075-18.163-18.165-0.439-2.247 0.249-4.539 1.841-6.129l1.847-1.847c0.256-0.257 0.596-0.397 0.959-0.397s0.703 0.14 0.959 0.397l3.883 3.883c0.256 0.256 0.397 0.596 0.397 0.959s-0.141 0.703-0.397 0.96l-3.22 3.217c-0.383 0.384-0.496 0.959-0.287 1.457 1.813 4.339 5.343 7.868 9.683 9.684 0.497 0.207 1.073 0.095 1.457-0.288l3.22-3.22c0.529-0.529 1.389-0.528 1.917 0l3.881 3.883c0.528 0.529 0.528 1.389 0 1.919z',
        'email' => 'M28 2.667h-24c-2.205 0-4 1.795-4 4v18.667c0 2.205 1.795 4 4 4h24c2.205 0 4-1.795 4-4v-18.667c0-2.205-1.795-4-4-4zM29.333 25.333c0 0.735-0.599 1.333-1.333 1.333h-24c-0.735 0-1.333-0.599-1.333-1.333v-12.685l10.54 4.865c0.888 0.409 1.84 0.613 2.793 0.613s1.907-0.204 2.793-0.615l10.54-4.864zM29.333 9.711l-11.657 5.38c-1.065 0.492-2.288 0.492-3.353 0l-11.656-5.38v-3.044c0-0.735 0.599-1.333 1.333-1.333h24c0.735 0 1.333 0.599 1.333 1.333z',
    ];
@endphp

<footer
    class="relative bg-white/80 backdrop-blur-xl text-slate-900 border-t border-slate-200/60 dark:bg-[#0c0f10] dark:border-white/10 dark:text-gray-200">

    <!-- TOP -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid gap-12 lg:grid-cols-3">

            <!-- Company -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold">{{ $company['name'] ?? 'Otex for E-Commerce' }}</h3>

                <p class="text-sm leading-7 text-slate-700 dark:text-gray-300">
                    {{ $company['description'] ?? 'Premium automotive marketplace built for customers who expect premium experiences.' }}
                </p>

                <div class="flex flex-wrap items-center gap-4">
                    @foreach ($company['registrations'] ?? [] as $registration)
                        <div class="text-sm text-slate-700 dark:text-gray-300">
                            <p class="text-slate-600 dark:text-gray-300">{{ $registration['label'] }}</p>
                            <p class="font-semibold">{{ $registration['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Links -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold">Important links</h3>
                <ul class="space-y-4 text-sm text-slate-700 dark:text-gray-300">
                    @foreach ($links as $link)
                        <li>
                            <a href="{{ $link['url'] ?? '#' }}" class="hover:text-white">
                                {{ $link['label'] ?? 'Link' }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Contact -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold">Contact</h3>

                <div class="space-y-4 text-sm text-slate-700 dark:text-gray-300">
                    @foreach ($contacts as $contact)
                        <div class="flex items-center gap-4">
                            <span class="s-contacts-icon">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                    viewBox="0 0 32 32">
                                    <path d="{{ $contactIconPaths[$contact['type'] ?? 'phone'] }}"></path>
                                </svg>
                            </span>
                            <a href="{{ $contact['url'] ?? '#' }}" class="hover:text-slate-900 dark:hover:text-white">
                                {{ $contact['label'] ?? '' }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <!-- BOTTOM BAR -->
    <div class="border-t border-slate-200/40 bg-slate-950/95 backdrop-blur">
        <div class="container mx-auto flex flex-col gap-4 px-4 py-5 md:flex-row md:items-center md:justify-between">

            <!-- Payment icons -->
            <div class="flex flex-wrap items-center gap-3">
                @foreach ($payments as $payment)
                    <img src="{{ $payment['src'] ?? '#' }}"
                        alt="{{ $payment['alt'] ?? 'Payment' }}"
                        class="h-10 w-14 rounded bg-white p-2 ring-1 ring-slate-200 dark:bg-white/5 dark:ring-white/10">
                @endforeach
            </div>

            <!-- Copyright -->
            <p class="text-sm text-gray-400 text-center">
                {{ $copyrightText }}
            </p>

        </div>
    </div>

</footer>
