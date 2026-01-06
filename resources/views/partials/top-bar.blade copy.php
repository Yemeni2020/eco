<div class="relative z-[60] hidden md:block bg-white text-slate-600 text-xs py-1.5 backdrop-blur-sm border-b border-slate-200 dark:bg-slate-900/95 dark:text-slate-300 dark:border-slate-800 transition-colors">
{{-- <div class="bg-slate-900/95 text-slate-300 text-xs py-1.5 hidden md:block backdrop-blur-sm"> --}}
    <div class="container mx-auto px-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 text-slate-600 dark:text-slate-300">
                <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                <circle cx="12" cy="10" r="3"></circle>
            </svg>
            <span class="text-slate-700 dark:text-slate-200">Ship to: <span class="font-semibold text-slate-900 dark:text-white">New York, US</span></span>
        </div>

        <div class="flex items-center gap-4">
            <div class="relative text-slate-800 dark:text-white">
                <button type="button" id="currencyToggle" class="flex items-center gap-2 rounded px-3 py-1 border border-slate-200 dark:border-slate-700 bg-white/90 dark:bg-slate-800/70 text-xs font-semibold shadow-sm hover:border-blue-400 focus:outline-none focus:ring-1 focus:ring-blue-400">
                    <img src="{{ asset('img/Saudi_Riyal_Symbol-2_2.svg') }}" alt="Saudi Riyal" class="h-4 w-auto currency-icon">
                    <span class="currency-label">Saudi Riyal</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 transition-transform duration-150" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div id="currencyMenu" class="absolute right-0 mt-1 w-44 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-100 text-xs rounded shadow-lg border border-slate-200 dark:border-slate-700 hidden z-[70]">
                    <button type="button" class="w-full flex items-center gap-2 px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" data-currency="SAR">
                        <img src="{{ asset('img/Saudi_Riyal_Symbol-2_2.svg') }}" alt="Saudi Riyal" class="h-4 w-auto">
                        <span>SAR - Saudi Riyal</span>
                    </button>
                    <button type="button" class="w-full flex items-center gap-2 px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" data-currency="USD">
                        <span class="font-semibold">$</span>
                        <span>USD - US Dollar</span>
                    </button>
                    <button type="button" class="w-full flex items-center gap-2 px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" data-currency="EUR">
                        <span class="font-semibold">€</span>
                        <span>EUR - Euro</span>
                    </button>
                </div>
            </div>
            <span class="hover:text-slate-900 dark:hover:text-white cursor-pointer transition-colors">Track Order</span>
            <span class="hover:text-slate-900 dark:hover:text-white cursor-pointer transition-colors">Support</span>
            <span class="text-blue-600 dark:text-blue-400 font-semibold">Free Shipping on order $100</span>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('currencyToggle');
    const menu = document.getElementById('currencyMenu');
    if (!toggle || !menu) return;

    const arrow = toggle.querySelector('svg');
    const buttons = menu.querySelectorAll('button[data-currency]');
    const icon = toggle.querySelector('.currency-icon');
    const label = toggle.querySelector('.currency-label');

    const closeMenu = () => {
        menu.classList.add('hidden');
        if (arrow) arrow.classList.remove('rotate-180');
    };

    toggle.addEventListener('click', (e) => {
        e.preventDefault();
        const isOpen = !menu.classList.contains('hidden');
        if (isOpen) {
            closeMenu();
        } else {
            menu.classList.remove('hidden');
            if (arrow) arrow.classList.add('rotate-180');
        }
    });

    buttons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const currency = btn.getAttribute('data-currency') || '';
            if (currency === 'SAR') {
                if (icon) {
                    icon.classList.remove('hidden');
                    icon.setAttribute('src', "{{ asset('img/Saudi_Riyal_Symbol-2_2.svg') }}");
                    icon.setAttribute('alt', 'Saudi Riyal');
                }
                if (label) label.textContent = 'Saudi Riyal';
            } else {
                if (icon) icon.classList.add('hidden');
                if (label) {
                    if (currency === 'USD') label.textContent = 'US Dollar';
                    if (currency === 'EUR') label.textContent = 'Euro';
                }
            }
            closeMenu();
        });
    });

    document.addEventListener('click', (e) => {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
            closeMenu();
        }
    });
});
</script>
@endpush
