@extends('admin.layouts.app')

@section('content')
    <div class="flex w-full flex-col gap-6">
        <div class="flex flex-col gap-2">
            <flux:heading size="xl" level="1">Customer details</flux:heading>
            <flux:text>Phone-only OTP login data.</flux:text>
        </div>

        @if (session('status'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Phone</dt>
                    <dd class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $customer->phone }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Normalized</dt>
                    <dd class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $customer->phone_normalized }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Status</dt>
                    <dd class="text-lg font-semibold">
                        @if ($customer->isBlocked())
                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 dark:bg-red-500/20">Blocked</span>
                        @else
                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/20">Active</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Joined</dt>
                    <dd class="text-lg font-semibold text-zinc-900 dark:text-white">
                        {{ $customer->created_at->format('M j, Y H:i') }}
                    </dd>
                </div>
            </dl>

            <div class="mt-6 flex gap-3">
                <form action="{{ route('admin.customers.block', $customer) }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="rounded-full border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100"
                    >
                        {{ $customer->isBlocked() ? 'Unblock customer' : 'Block customer' }}
                    </button>
                </form>
                <a href="{{ route('admin.customers.index') }}" class="rounded-full border border-transparent px-4 py-2 text-sm font-semibold text-blue-600 hover:bg-blue-50">
                    Back to list
                </a>
            </div>
        </div>
    </div>
@endsection
