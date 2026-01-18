<!DOCTYPE html>
<html lang="{{ $htmlLang ?? app()->getLocale() ?? 'en' }}" dir="{{ $htmlDir ?? 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Otex</title>
    @vite('resources/css/app.css')
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
    <script>
        window.tailwind = window.tailwind || {};
        window.tailwind.config = window.tailwind.config || {};
        window.tailwind.config.darkMode = 'class';
    </script>
</head>

<body dir="{{ $htmlDir ?? 'ltr' }}" class="bg-gray-100 text-gray-900 {{ ($htmlDir ?? 'ltr') === 'rtl' ? 'not-italic' : '' }}">
    <div id="pageLoader" class="fixed inset-0 z-[9999] flex min-h-screen items-center justify-center bg-[#f5f9ff]">
        <div class="flex flex-col items-center gap-6">
            <div class="relative h-16 w-16">
                <div class="absolute inset-0 rounded-full border-2 border-blue-200"></div>
                <div class="absolute inset-0 rounded-full border-2 border-blue-500 border-t-transparent animate-spin">
                </div>
                <div class="absolute inset-4 rounded-full bg-white shadow-[0_12px_30px_rgba(59,130,246,0.25)]"></div>
            </div>
            <div class="text-xs uppercase tracking-[0.35em] text-blue-400">Loading garage</div>
        </div>
    </div>

    <div class="flex min-h-screen flex-col">
        @include('partials.top-bar')

        <x-navbar />
        <main class="flex-1 bg-white" style="padding-top: var(--header-stack-height, 0px);">
        @yield('content')
        {{ $slot ?? '' }}
        </main>

        @include('partials.footer')
    </div>

    <!-- WhatsApp (mobile) -->
    <a href="https://wa.me/966000000000" aria-label="Chat on WhatsApp"
        class="fixed bottom-27 right-4 z-40 inline-flex h-12 w-12 items-center justify-center rounded-full bg-emerald-500 text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-emerald-600 active:translate-y-0 sm:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 32 32" fill="currentColor"
            aria-hidden="true">
            <path
                d="M27.281 4.65c-2.994-3-6.975-4.65-11.219-4.65-8.738 0-15.85 7.112-15.85 15.856 0 2.794 0.731 5.525 2.119 7.925l-2.25 8.219 8.406-2.206c2.319 1.262 4.925 1.931 7.575 1.931h0.006c8.738 0 15.856-7.113 15.856-15.856 0-4.238-1.65-8.219-4.644-11.219zM16.069 29.050v0c-2.369 0-4.688-0.637-6.713-1.837l-0.481-0.288-4.987 1.306 1.331-4.863-0.313-0.5c-1.325-2.094-2.019-4.519-2.019-7.012 0-7.269 5.912-13.181 13.188-13.181 3.519 0 6.831 1.375 9.319 3.862 2.488 2.494 3.856 5.8 3.856 9.325-0.006 7.275-5.919 13.188-13.181 13.188zM23.294 19.175c-0.394-0.2-2.344-1.156-2.706-1.288s-0.625-0.2-0.894 0.2c-0.262 0.394-1.025 1.288-1.256 1.556-0.231 0.262-0.462 0.3-0.856 0.1s-1.675-0.619-3.188-1.969c-1.175-1.050-1.975-2.35-2.206-2.744s-0.025-0.613 0.175-0.806c0.181-0.175 0.394-0.463 0.594-0.694s0.262-0.394 0.394-0.662c0.131-0.262 0.069-0.494-0.031-0.694s-0.894-2.15-1.219-2.944c-0.319-0.775-0.65-0.669-0.894-0.681-0.231-0.012-0.494-0.012-0.756-0.012s-0.694 0.1-1.056 0.494c-0.363 0.394-1.387 1.356-1.387 3.306s1.419 3.831 1.619 4.1c0.2 0.262 2.794 4.269 6.769 5.981 0.944 0.406 1.681 0.65 2.256 0.837 0.95 0.3 1.813 0.256 2.494 0.156 0.762-0.113 2.344-0.956 2.675-1.881s0.331-1.719 0.231-1.881c-0.094-0.175-0.356-0.275-0.756-0.475z">
            </path>
        </svg>
    </a>

    <!-- Scroll to top -->
    <button id="scrollToTop" aria-label="Scroll to top"
        class="scroll-to-top fixed bottom-6 right-4 z-40 !hidden lg:!block transition-opacity duration-300 opacity-0"
        type="button">
        <svg class="progress-circle svg-content" width="56" height="56" viewBox="-1 -1 102 102">
            <path id="scrollToTopPath" d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                class="stroke-[3] stroke-blue-500 fill-white drop-shadow"
                style="stroke-dasharray: 307.919; stroke-dashoffset: 307.919; transition: stroke-dashoffset 0.5s ease;">
            </path>
            <polyline points="50 28 35 45 42 45 42 70 58 70 58 45 65 45 50 28"
                class="fill-blue-500/10 stroke-blue-600 stroke-[3] rounded-sm"></polyline>
        </svg>
    </button>

    <!-- Notifications region -->
    <div role="region" aria-label="Notifications (F8)" tabindex="-1" style="pointer-events: none;">
        <ol id="toastRegion" tabindex="-1"
            class="fixed top-0 z-[100] flex max-h-screen w-full flex-col-reverse p-4 sm:bottom-0 sm:right-0 sm:top-auto sm:flex-col md:max-w-[420px]">
        </ol>
    </div>

    @livewireScripts
    @stack('scripts')
<script>
    /**
 * App UI Script (clean + guarded)
 * - Header/topbar offset + hide on scroll
 * - Theme (single source of truth)
 * - Cart open (Livewire dispatch) + close (CSS toggles)
 * - Add-to-cart feedback + wishlist toggle
 * - Password helpers (settings)
 * - Mobile menu + mobile search
 * - Scroll-to-top progress button
 * - Toast notifications (window dispatchEvent(new CustomEvent('notify',{detail:{message:".."}})))
 * - Livewire infinite scroll helper
 *
 * NOTE:
 * 1) Remove your extra duplicate theme script (the one using #toggle) — this file already handles theme.
 * 2) Do NOT silence console globally in production. Keep logs for debugging.
 */

(() => {
  // ---------- Utilities ----------
  const $ = (sel, root = document) => root.querySelector(sel);
  const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

  const raf = (fn) => requestAnimationFrame(fn);
  const on = (el, evt, handler, opts) => el && el.addEventListener(evt, handler, opts);
  const isSmall = () => window.innerWidth < 640;

  // ---------- Header / Topbar offset ----------
  const initHeaderOffset = () => {
    const header = $('#siteHeader');
    const topbar = $('#siteTopbar');
    if (!header && !topbar) return;

    const setHeaderOffset = () => {
      const topbarHeight = topbar && !topbar.classList.contains('topbar-hidden') ? topbar.offsetHeight : 0;
      const headerHeight = header ? header.offsetHeight : 0;
      document.documentElement.style.setProperty('--topbar-height', `${topbarHeight}px`);
      document.documentElement.style.setProperty('--header-stack-height', `${topbarHeight + headerHeight}px`);
    };

    setHeaderOffset();
    on(window, 'resize', setHeaderOffset);

    if (topbar) {
      let lastY = window.pageYOffset || 0;

      const handleScroll = () => {
        const y = window.pageYOffset || 0;
        const down = y > lastY;

        if (y <= 10) topbar.classList.remove('topbar-hidden');
        else if (down) topbar.classList.add('topbar-hidden');
        else topbar.classList.remove('topbar-hidden');

        lastY = y;
        setHeaderOffset();
      };

      handleScroll();
      on(window, 'scroll', handleScroll, { passive: true });
    }
  };

  // ---------- Cart ----------
  const initCart = () => {
    const cartSidebar = $('#cartSidebar');
    const cartBackdrop = $('#cartBackdrop');
    const closeCart = $('#closeCart');

    if (!cartSidebar) return;

    const close = () => {
      cartSidebar.classList.add('translate-x-full');
      if (cartBackdrop) cartBackdrop.classList.add('hidden');
    };

    on(closeCart, 'click', (e) => { e.preventDefault(); close(); });
    on(cartBackdrop, 'click', close, { passive: true });
  };

  const updateCartBadges = (count) => {
    const normalized = Number(count) || 0;
    $$('[data-cart-count]').forEach((badge) => {
      badge.textContent = normalized;
      badge.classList.toggle('hidden', normalized <= 0);
      badge.setAttribute('aria-hidden', normalized <= 0 ? 'true' : 'false');
    });
  };

  const showCartFeedback = (button) => {
    const cartIcon = $('[data-cart-icon]', button);
    const checkIcon = $('[data-check-icon]', button);
    if (!cartIcon || !checkIcon) return;

    cartIcon.classList.add('hidden');
    checkIcon.classList.remove('hidden');

    if (button._cartFeedbackTimer) clearTimeout(button._cartFeedbackTimer);
    button._cartFeedbackTimer = setTimeout(() => {
      cartIcon.classList.remove('hidden');
      checkIcon.classList.add('hidden');
    }, 1400);
  };

  const initRealtimeAddToCart = () => {
    const cartAddUrl = @json(route('cart.items.store', ['locale' => app()->getLocale()]));
    const successMessage = @json(__('Item added to cart.'));
    const failureMessage = @json(__('Unable to add item to cart.'));

    if (!cartAddUrl) {
      return;
    }

    const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

    const handler = async (event) => {
      const button = event.target.closest?.('[data-add-to-cart]');
      if (!button) return;
      if (button._isAdding) return;

      const form = button.closest('form');
      const productId = button.dataset.productId ?? form?.querySelector('[name="product_id"]')?.value;

      if (!productId) {
        console.warn('Add-to-cart button is missing a product ID.');
        return;
      }

      const qtyValue = button.dataset.qty ?? form?.querySelector('[name="qty"]')?.value ?? '1';
      const quantity = Math.max(1, parseInt(qtyValue, 10) || 1);

      const originalDisabled = button.disabled;
      button._isAdding = true;
      button.disabled = true;
      button.setAttribute('aria-busy', 'true');

      try {
        const response = await fetch(cartAddUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            'X-CSRF-TOKEN': getCsrfToken(),
          },
          credentials: 'same-origin',
          body: JSON.stringify({
            product_id: productId,
            qty: quantity,
          }),
        });

        if (!response.ok) {
          const payload = await response.json().catch(() => null);
          throw new Error(payload?.message || failureMessage);
        }

        const payload = await response.json();

        updateCartBadges(payload.cart_count ?? 0);
        window.dispatchEvent(new CustomEvent('cart:updated', { detail: payload }));
        window.Livewire?.emit('cartUpdated');
        window.dispatchEvent(
          new CustomEvent('notify', {
            detail: { message: payload.message ?? successMessage },
          }),
        );

        showCartFeedback(button);
      } catch (error) {
        window.dispatchEvent(
          new CustomEvent('notify', {
            detail: { message: error instanceof Error ? error.message : failureMessage },
          }),
        );
      } finally {
        button._isAdding = false;
        button.disabled = originalDisabled;
        button.removeAttribute('aria-busy');
      }
    };

    on(document, 'click', handler);

    document.addEventListener('cart:updated', (event) => {
      const count = event.detail?.cart_count;
      if (count !== undefined) {
        updateCartBadges(count);
      }
    });
  };

  // ---------- Add-to-cart feedback ----------
  const initAddToCartFeedback = () => {
    document.addEventListener('livewire:updated', () => {
      const button = document.activeElement?.closest?.('[data-add-to-cart]');
      if (button) showCartFeedback(button);
    });

    on(document, 'click', (event) => {
      const button = event.target.closest?.('[data-add-to-cart]');
      if (button) showCartFeedback(button);
    });
  };

  // ---------- Wishlist toggle ----------
  const initWishlist = () => {
    const handler = (event) => {
      const button = event.target.closest?.('[data-wishlist]');
      if (!button) return;

      const icon = $('svg', button);
      const isActive = button.getAttribute('aria-pressed') === 'true';
      const next = !isActive;

      button.setAttribute('aria-pressed', next ? 'true' : 'false');
      button.classList.toggle('text-red-500', next);
      button.classList.toggle('text-slate-700', !next);

      if (icon) icon.classList.toggle('fill-current', next);
    };

    on(document, 'click', handler);
  };

  // ---------- Password UI (settings page) ----------
  const initPasswordUI = () => {
    window.togglePassword = (button) => {
      const field = button?.closest?.('.password-field');
      const target = field ? $('input', field) : null;
      if (!target) return;

      const isPassword = target.getAttribute('type') === 'password';
      target.setAttribute('type', isPassword ? 'text' : 'password');
      button.textContent = isPassword ? 'Hide' : 'Show';
      button.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
    };

    const update = () => {
      const newPassword = $('#newPassword');
      const confirmPassword = $('#confirmPassword');
      const strengthLabel = $('#passwordStrengthLabel');
      const strengthBar = $('#passwordStrengthBar');
      const matchHint = $('#passwordMatchHint');
      const updateButton = $('#updatePasswordButton');
      const ruleItems = $$('#passwordRules [data-rule]');

      if (!newPassword || !confirmPassword || !strengthLabel || !strengthBar || !matchHint || !updateButton) return;

      const value = newPassword.value || '';
      const rules = {
        length: value.length >= 12,
        case: /[a-z]/.test(value) && /[A-Z]/.test(value),
        number: /[0-9]/.test(value),
        symbol: /[^A-Za-z0-9]/.test(value),
      };

      const passedCount = Object.values(rules).filter(Boolean).length;
      const labels = ['Very weak', 'Weak', 'Fair', 'Good', 'Strong'];
      const colors = ['bg-rose-500', 'bg-amber-500', 'bg-yellow-500', 'bg-lime-500', 'bg-emerald-500'];
      const widths = ['w-1/5', 'w-2/5', 'w-3/5', 'w-4/5', 'w-full'];
      const idx = Math.min(passedCount, 4);

      strengthBar.className = 'h-2 rounded-full transition-all';

      if (!value.length) {
        strengthLabel.textContent = '-';
        strengthBar.classList.add('bg-slate-400', 'w-0');
      } else {
        strengthLabel.textContent = labels[idx];
        strengthBar.classList.add(colors[idx], widths[idx]);
      }

      ruleItems.forEach((item) => {
        const key = item.getAttribute('data-rule');
        const passed = !!rules[key];
        item.classList.toggle('text-emerald-600', passed);
        item.classList.toggle('text-slate-600', !passed);
      });

      const matches = confirmPassword.value.length > 0 && confirmPassword.value === value;

      if (!confirmPassword.value.length) {
        matchHint.textContent = '-';
        matchHint.classList.remove('text-emerald-600', 'text-rose-600');
      } else if (matches) {
        matchHint.textContent = 'Passwords match';
        matchHint.classList.add('text-emerald-600');
        matchHint.classList.remove('text-rose-600');
      } else {
        matchHint.textContent = 'Passwords do not match';
        matchHint.classList.add('text-rose-600');
        matchHint.classList.remove('text-emerald-600');
      }

      const valid = passedCount >= 4 && matches;
      updateButton.disabled = !valid;
      updateButton.classList.toggle('opacity-60', !valid);
      updateButton.classList.toggle('cursor-not-allowed', !valid);
    };

    window.updatePasswordStrength = update;

    on(document, 'input', (event) => {
      const id = event.target?.id;
      if (id === 'newPassword' || id === 'confirmPassword') update();
    });

    update();
  };

  // ---------- Mobile menu ----------
  const initMobileMenu = () => {
    const btn = $('#mobileMenuButton');
    const menu = $('#mobileMenu');
    const iconOpen = $('#mobileMenuIconOpen');
    const iconClose = $('#mobileMenuIconClose');
    if (!btn || !menu) return;

    let open = false;

    const openMenu = () => {
      menu.classList.remove('hidden');
      raf(() => {
        menu.classList.add('mobile-menu-open');
        menu.classList.remove('pointer-events-none');
      });
      iconOpen && iconOpen.classList.add('hidden');
      iconClose && iconClose.classList.remove('hidden');
      open = true;
    };

    const closeMenu = () => {
      menu.classList.remove('mobile-menu-open');
      menu.classList.add('pointer-events-none');
      setTimeout(() => menu.classList.add('hidden'), 180);
      iconOpen && iconOpen.classList.remove('hidden');
      iconClose && iconClose.classList.add('hidden');
      open = false;
    };

    on(btn, 'click', (e) => {
      e.preventDefault();
      open ? closeMenu() : openMenu();
    });
  };

  // ---------- Mobile search ----------
  const initMobileSearch = () => {
    const btn = $('#mobileSearchButton');
    const bar = $('#mobileSearchBar');
    if (!btn || !bar) return;

    let open = false;

    const openSearch = () => {
      bar.classList.remove('hidden');
      raf(() => {
        bar.classList.add('mobile-menu-open');
        bar.classList.remove('pointer-events-none');
      });
      open = true;
    };

    const closeSearch = () => {
      bar.classList.remove('mobile-menu-open');
      bar.classList.add('pointer-events-none');
      setTimeout(() => bar.classList.add('hidden'), 180);
      open = false;
    };

    on(btn, 'click', (e) => {
      e.preventDefault();
      open ? closeSearch() : openSearch();
    });
  };

  // ---------- Scroll-to-top progress ----------
  const initScrollToTop = () => {
    const scrollBtn = $('#scrollToTop');
    const scrollPath = $('#scrollToTopPath');
    if (!scrollBtn || !scrollPath) return;

    const pathLength = scrollPath.getTotalLength();
    scrollPath.style.strokeDasharray = `${pathLength} ${pathLength}`;
    scrollPath.style.strokeDashoffset = pathLength;

    const update = () => {
      if (isSmall()) {
        scrollBtn.classList.add('hidden', 'opacity-0');
        return;
      }

      const scroll = window.pageYOffset || 0;
      const height = document.documentElement.scrollHeight - window.innerHeight;
      const progress = pathLength - (scroll * pathLength) / (height || 1);
      scrollPath.style.strokeDashoffset = progress;

      const show = scroll > 200;
      scrollBtn.classList.toggle('hidden', !show);
      scrollBtn.classList.toggle('opacity-0', !show);
    };

    update();
    on(window, 'scroll', update, { passive: true });
    on(scrollBtn, 'click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
  };

  // ---------- Toast notifications ----------
  const initToasts = () => {
    on(window, 'notify', (event) => {
      const list = $('#toastRegion');
      if (!list) return;

      const message = event.detail?.message || 'Notification';

      const item = document.createElement('li');
      item.className =
        'pointer-events-auto mb-3 rounded-lg shadow-lg border border-blue-100 bg-gradient-to-r from-blue-50 to-indigo-50 text-slate-800 overflow-hidden';

      const body = document.createElement('div');
      body.className = 'flex items-start gap-3 px-4 py-3';
      body.innerHTML = `
        <div class="mt-0.5 h-2 w-2 rounded-full bg-blue-500"></div>
        <div class="flex-1 text-sm font-medium text-slate-800">${message}</div>
        <button type="button" aria-label="Close notification" class="text-slate-500 hover:text-slate-700">&times;</button>
      `;

      const bar = document.createElement('div');
      bar.className = 'h-1 bg-blue-500 w-full';
      bar.style.transition = 'width 3s linear';

      item.appendChild(body);
      item.appendChild(bar);
      list.appendChild(item);

      raf(() => (bar.style.width = '0%'));

      const remove = () => {
        item.classList.add('opacity-0', 'transition', 'duration-300');
        setTimeout(() => item.remove(), 300);
      };

      on($('button', body), 'click', remove, { once: true });
      setTimeout(remove, 3000);
    });
  };

  // ---------- Livewire infinite scroll helper ----------
  const initInfiniteScroll = () => {
    document.addEventListener('livewire:init', () => {
      const attach = () => {
        $$('[data-infinite-scroll]').forEach((section) => {
          const sentinel = $('[data-infinite-scroll-sentinel]', section);
          if (!sentinel || sentinel.dataset.infiniteWatching) return;

          const componentEl = section.closest('[wire\\:id]');
          if (!componentEl) return;

          const componentId = componentEl.getAttribute('wire:id');
          const livewireInstance = () => window.Livewire?.find(componentId);

          const observer = new IntersectionObserver(
            (entries) => {
              entries.forEach((entry) => {
                if (entry.isIntersecting) livewireInstance()?.call('loadMore');
              });
            },
            { rootMargin: '320px' }
          );

          sentinel.dataset.infiniteWatching = '1';
          sentinel._infiniteObserver = observer;
          observer.observe(sentinel);
        });
      };

      attach();

      // re-attach after Livewire morphs
      const mo = new MutationObserver(() => attach());
      mo.observe(document.body, { childList: true, subtree: true });
    });
  };

  // ---------- Boot ----------
  document.addEventListener('DOMContentLoaded', () => {
    initHeaderOffset();
    initCart();
    initRealtimeAddToCart();
    initAddToCartFeedback();
    initWishlist();
    initPasswordUI();
    initMobileMenu();
    initMobileSearch();
    initScrollToTop();
    initToasts();
    initInfiniteScroll();
  });

  // ✅ Optional: keep this ONLY if you really need to block noisy extension messages
  // (I recommend removing it unless you know why it’s needed.)
  // const shouldBlockMessageEvent = (event) => {
  //   if (event?.data?.source === 'react-devtools-content-script') return true;
  //   if (!event.origin || !window.location?.origin) return true;
  //   return event.origin !== window.location.origin;
  // };
  // window.addEventListener('message', (event) => {
  //   if (shouldBlockMessageEvent(event)) event.stopImmediatePropagation();
  // }, true);

  // ❌ Removed: global console silencing (bad for debugging + production visibility)
})();
</script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
</body>

</html>
