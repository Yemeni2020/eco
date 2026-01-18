@extends('components.layouts.app')

@section('content')
    <main class="flex min-h-screen items-center justify-center bg-slate-50 text-slate-900">
        <div class="grid w-full max-w-6xl grid-cols-1 gap-6 rounded-[30px] bg-white shadow-xl shadow-slate-200 lg:grid-cols-[1.1fr,0.9fr]">
            <div class="space-y-8 px-6 py-12 sm:px-10 lg:px-14">
                <div>
                    <img src="{{ asset('img/logo_text.svg') }}" alt="Otex logo" class="h-10">
                    <h1 class="mt-6 text-3xl font-semibold text-slate-900">Login with your phone</h1>
                    <p class="mt-2 text-sm text-slate-500">
                        Enter your phone to receive a one-time password. New customers are created automatically.
                    </p>
                </div>

                @if (session('status'))
                    <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('phone.login.request') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label for="phone" class="text-sm font-medium text-slate-700">Phone number</label>
                        <div class="flex overflow-hidden rounded-2xl border border-slate-200 bg-white">
                            <span class="flex items-center justify-center px-4 text-sm font-semibold text-slate-600 bg-slate-50 border-r border-slate-200">
                                +966
                            </span>
                            <input
                                id="phone"
                                name="phone"
                                type="tel"
                                value="{{ old('phone') }}"
                                required
                                placeholder="051 234 5678"
                                class="flex-1 border-none px-4 py-3 text-sm text-slate-900 focus:outline-none"
                            >
                        </div>
                        @error('phone')
                            <p class="text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold uppercase tracking-wide text-white transition hover:bg-black focus:outline-none focus:ring-2 focus:ring-slate-900/30"
                    >
                        <span>Send OTP</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6" />
                        </svg>
                    </button>
                </form>

                <div class="text-center text-xs uppercase tracking-[0.4em] text-slate-400">
                    OR
                </div>

                <div class="flex justify-center gap-4 text-sm font-semibold">
                    <a href="{{ route('login.email') }}" class="text-slate-500 hover:text-slate-900">Login via email</a>
                    <span class="text-slate-300">•</span>
                    <a href="{{ route('register') }}" class="text-slate-500 hover:text-slate-900">Create account</a>
                </div>
            </div>

            <div class="hidden rounded-[30px] bg-[url('/img/login_img.avif')] bg-cover bg-center lg:block">
                <div class="flex h-full items-center justify-center bg-gradient-to-r from-slate-900/80 to-slate-900/10 px-12">
                    <div class="text-center text-white">
                        <p class="text-sm uppercase tracking-[0.5em]">Welcome</p>
                        <h2 class="mt-4 text-3xl font-semibold">Fast, secure login with SMS</h2>
                        <p class="mt-4 text-sm text-white/80">No passwords, no hassle. Just confirm your phone number and keep shopping.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
