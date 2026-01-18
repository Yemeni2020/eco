@extends('admin.layouts.app')

@section('content')
    <div class="flex w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <flux:heading size="xl" level="1">Customer manager</flux:heading>
                <flux:text>Monitor sign-ups and control access.</flux:text>
            </div>
            <span class="rounded-full border border-gray-200 px-4 py-1 text-sm text-gray-600 dark:border-zinc-700 dark:text-zinc-300">
                {{ number_format($customers->total()) }} customers
            </span>
        </div>

        @if (session('status'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="rounded-xl border border-zinc-200 bg-white shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 text-sm dark:divide-zinc-700">
                    <thead class="bg-zinc-50 text-xs uppercase tracking-wide text-zinc-500 dark:bg-zinc-800/60 dark:text-zinc-400">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium">Phone</th>
                            <th class="px-4 py-3 text-left font-medium">Created</th>
                            <th class="px-4 py-3 text-left font-medium">Status</th>
                            <th class="px-4 py-3 text-right font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 text-zinc-700 dark:divide-zinc-800 dark:text-zinc-300">
                        @forelse ($customers as $customer)
                            <tr>
                                <td class="px-4 py-4 font-semibold text-zinc-900 dark:text-white">
                                    {{ $customer->phone }}
                                </td>
                                <td class="px-4 py-4">
                                    {{ $customer->created_at->format('M j, Y H:i') }}
                                </td>
                                <td class="px-4 py-4">
                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $customer->isBlocked() ? 'bg-red-100 text-red-700 dark:bg-red-500/20' : 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/20' }}"
                                    >
                                        {{ $customer->isBlocked() ? 'Blocked' : 'Active' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a
                                            href="{{ route('admin.customers.show', $customer) }}"
                                            class="text-sm font-semibold text-blue-600 hover:underline"
                                        >
                                            View
                                        </a>
                                        <form action="{{ route('admin.customers.block', $customer) }}" method="POST">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="rounded-full border border-gray-200 px-3 py-1 text-xs font-semibold text-gray-700 hover:bg-gray-100"
                                            >
                                                {{ $customer->isBlocked() ? 'Unblock' : 'Block' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">
                                    No customers have signed up yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-end">
            {{ $customers->links() }}
        </div>
    </div>
@endsection
