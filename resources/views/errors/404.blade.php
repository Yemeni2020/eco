<x-layouts.app>
    <div class="min-h-screen grid md:grid-cols-2 bg-white dark:bg-slate-900">
        <main class="flex items-center justify-center px-6 py-24 sm:py-32 lg:px-12">
            <div class="max-w-xl text-left">
                <p class="text-base font-semibold text-indigo-500 dark:text-indigo-300">404</p>
                <h1 class="mt-4 text-5xl font-semibold tracking-tight text-slate-900 dark:text-white sm:text-6xl">Page not
                    found</h1>
                <p class="mt-6 text-lg font-medium text-slate-600 dark:text-gray-300">Sorry, we couldn't find the page you're
                    looking for.</p>
                <div class="mt-10">
                    <a href="/"
                        class="inline-flex items-center gap-2 text-indigo-600 dark:text-indigo-300 font-semibold hover:text-indigo-500 dark:hover:text-indigo-200">
                        <span aria-hidden="true">&larr;</span> Back to home
                    </a>
                </div>
            </div>
        </main>
        <div class="relative hidden md:block">
            <img src="{{ asset('img/404_light.avif') }}" alt="Not found"
                class="absolute inset-0 w-full h-full object-cover opacity-90 dark:hidden">
            <img src="{{ asset('img/dark_mode.avif') }}" alt="Not found"
                class="absolute inset-0 w-full h-full object-cover opacity-60 hidden dark:block">
        </div>
    </div>
</x-layouts.app>
