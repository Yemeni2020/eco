<x-layouts.app>
    <main class="flex-grow bg-slate-50">
        <div class="min-h-screen grid lg:grid-cols-2">
            <div class="flex items-center justify-center px-6 py-12">
                <div class="w-full max-w-md">
                    <div class="mb-8">
                        <img src="{{ asset('img/logo_text.svg') }}" alt="Your Company" class="h-auto w-auto">
                        <h2 class="mt-6 text-2xl font-semibold text-slate-900">Reset your password</h2>
                        <p class="mt-2 text-sm text-slate-600">
                            Enter your phone number to receive a verification code.
                        </p>
                    </div>

                    <form action="#" method="POST" class="space-y-6">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-slate-700">Phone number</label>
                            <div class="mt-2">
                                <input id="phone" type="tel" name="phone" required autocomplete="tel"
                                    placeholder="+1 (555) 123-4567"
                                    class="block w-full rounded-lg border border-slate-200 px-4 py-2 text-sm text-slate-900 shadow-sm focus:border-[#1F4BD8] focus:outline-none focus:ring-2 focus:ring-[#1F4BD8]/20">
                            </div>
                        </div>

                        <button type="submit"
                            class="inline-flex w-full items-center justify-center rounded-lg bg-[#1F4BD8] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#1F4BD8] focus:outline-none focus:ring-2 focus:ring-[#1F4BD8]/30">
                            Send code
                        </button>
                    </form>

                    <p class="mt-6 text-sm text-slate-600">
                        Remembered your password?
                        <a href="{{ route('login') }}" class="font-semibold text-[#1F4BD8] hover:text-[#1F4BD8]">Sign in</a>
                    </p>
                </div>
            </div>

            <div class="hidden lg:block">
                <img src="{{ asset('img/login_img.avif') }}" alt="" class="h-full w-full object-cover">
            </div>
        </div>
    </main>
</x-layouts.app>
