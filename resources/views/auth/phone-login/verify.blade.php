@extends('components.layouts.app')

@section('content')
    <div class="mx-auto max-w-md px-4 py-20 sm:px-6 lg:px-8">
        <div class="rounded-lg bg-white p-8 shadow-sm">
            <h1 class="mb-2 text-2xl font-semibold">Verify your OTP</h1>

            @if (session('status'))
                <div class="mb-4 rounded border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('phone.login.verify.submit') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="phone" value="{{ $phone ?? old('phone') }}">

                <div>
                    <label for="code" class="text-sm font-medium text-gray-700">One-time code</label>
                    <input
                        id="code"
                        name="code"
                        type="text"
                        value="{{ old('code') }}"
                        required
                        autocomplete="one-time-code"
                        class="mt-1 block w-full rounded border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring focus:ring-blue-200"
                    >
                    @error('code')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                @error('phone')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror

                <button
                    type="submit"
                    class="w-full rounded bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-200"
                >
                    Verify &amp; Login
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-500">
                Need a new code?
                <a href="{{ route('login') }}" class="text-blue-600 underline">Request again.</a>
            </p>
        </div>
    </div>
@endsection
