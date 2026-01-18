<x-layouts.app>
    <main class="flex-grow bg-slate-50">
        <div class="min-h-screen grid lg:grid-cols-2">
            <div class="flex items-center justify-center px-6 py-12">
                <div class="w-full max-w-md space-y-8">
                    <div>
                        <img src="{{ asset('img/logo_text.svg') }}" alt="Otex logo" class="h-auto w-auto">
                        <h2 class="mt-6 text-2xl font-semibold text-slate-900">Sign in to your account</h2>
                        <p class="mt-2 text-sm text-slate-600">
                            Not a member?
                            <a href="{{ route('register') }}" class="font-semibold text-[#1F4BD8] hover:text-[#1F4BD8]">Sign up</a>
                        </p>
                    </div>

                    <form action="{{ route('login.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700">Email address</label>
                            <div class="mt-2">
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                                    class="block w-full rounded-lg border border-slate-200 px-4 py-2 text-sm text-slate-900 shadow-sm focus:border-[#1F4BD8] focus:outline-none focus:ring-2 focus:ring-[#1F4BD8]/20">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                            <div class="mt-2">
                                <input id="password" type="password" name="password" required autocomplete="current-password"
                                    class="block w-full rounded-lg border border-slate-200 px-4 py-2 text-sm text-slate-900 shadow-sm focus:border-[#1F4BD8] focus:outline-none focus:ring-2 focus:ring-[#1F4BD8]/20">
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 text-sm text-slate-600">
                                <input id="remember-me" type="checkbox" name="remember"
                                    class="h-4 w-4 rounded border-slate-300 text-[#1F4BD8] focus:ring-[#1F4BD8]">
                                Remember me
                            </label>
                            <a href="{{ route('password.request') }}" class="text-sm font-semibold text-[#1F4BD8] hover:text-[#1F4BD8]">Forgot password?</a>
                        </div>

                        <button type="submit"
                            class="inline-flex w-full items-center justify-center rounded-lg bg-[#1F4BD8] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#1F4BD8] focus:outline-none focus:ring-2 focus:ring-[#1F4BD8]/30">
                            Sign in
                        </button>
                    </form>

                    <div>
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-slate-200"></div>
                            </div>
                            <div class="relative flex justify-center text-xs uppercase text-slate-500">
                                <span class="bg-slate-50 px-2">Or continue with</span>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <a href="#"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-[#1877F2] shadow-sm hover:bg-slate-50">
                                <svg viewBox="0 0 24 24" aria-hidden="true" class="h-5 w-5">
                                    <path d="M12.0003 4.75C13.7703 4.75 15.3553 5.36002 16.6053 6.54998L20.0303 3.125C17.9502 1.19 15.2353 0 12.0003 0C7.31028 0 3.25527 2.69 1.28027 6.60998L5.27028 9.70498C6.21525 6.86002 8.87028 4.75 12.0003 4.75Z" fill="#EA4335"></path>
                                    <path d="M23.49 12.275C23.49 11.49 23.415 10.73 23.3 10H12V14.51H18.47C18.18 15.99 17.34 17.25 16.08 18.1L19.945 21.1C22.2 19.01 23.49 15.92 23.49 12.275Z" fill="#4285F4"></path>
                                    <path d="M5.26498 14.2949C5.02498 13.5699 4.88501 12.7999 4.88501 11.9999C4.88501 11.1999 5.01998 10.4299 5.26498 9.7049L1.275 6.60986C0.46 8.22986 0 10.0599 0 11.9999C0 13.9399 0.46 15.7699 1.28 17.3899L5.26498 14.2949Z" fill="#FBBC05"></path>
                                    <path d="M12.0004 24.0001C15.2404 24.0001 17.9654 22.935 19.9454 21.095L16.0804 18.095C15.0054 18.82 13.6204 19.245 12.0004 19.245C8.8704 19.245 6.21537 17.135 5.2654 14.29L1.27539 17.385C3.25539 21.31 7.3104 24.0001 12.0004 24.0001Z" fill="#34A853"></path>
                                </svg>
                                Google
                            </a>

                            <a href="#"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                                <svg viewBox="0 0 24 24" aria-hidden="true" class="h-5 w-5 fill-[#1877F2]">
                                    <path d="M22.675 0H1.325C.593 0 0 .593 0 1.326v21.348C0 23.407.593 24 1.325 24h11.495v-9.294H9.692V11.01h3.128V8.414c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.464.099 2.795.143v3.24h-1.918c-1.504 0-1.796.715-1.796 1.763v2.313h3.59l-.467 3.696h-3.123V24h6.116C23.407 24 24 23.407 24 22.674V1.326C24 .593 23.407 0 22.675 0z"></path>
                                </svg>
                                Facebook
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden lg:block">
                <img src="{{ asset('img/login_img.avif') }}" alt="" class="h-full w-full object-cover">
            </div>
        </div>
    </main>
</x-layouts.app>
