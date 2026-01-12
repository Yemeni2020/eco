<x-layouts.app>
    <section class="bg-gradient-to-br from-slate-900 to-slate-800 text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-semibold">Password</h1>
            <p class="mt-2 text-sm text-slate-300">Update your credentials to protect your account.</p>
        </div>
    </section>

    <section class="container mx-auto px-4 py-12">
        <div class="mx-auto max-w-2xl">
            <x-card>
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-900">Change password</h2>
                    <a href="{{ route('account.profile.edit') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Edit profile</a>
                </div>

                @if(session('status'))
                    <div class="mt-6">
                        <x-alert type="success">{{ session('status') }}</x-alert>
                    </div>
                @endif

                <form id="passwordForm" method="POST" action="{{ route('account.password.update') }}" class="mt-6 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-slate-700">Current password</label>
                        <x-input id="current_password" name="current_password" type="password" placeholder="current password" autocomplete="current-password" />
                        @error('current_password')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700">New password</label>
                        <x-input id="password" name="password" type="password" placeholder="new password" autocomplete="new-password" />
                        @error('password')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirm password</label>
                        <x-input id="password_confirmation" name="password_confirmation" type="password" placeholder="confirm password" autocomplete="new-password" />
                        @error('password_confirmation')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="text-right">
                        <button id="passwordSubmit" type="submit" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold uppercase tracking-[0.3em] text-white transition hover:bg-slate-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-950">
                            Update password
                        </button>
                    </div>
                </form>
            </x-card>
        </div>
    </section>
</x-layouts.app>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('passwordForm');
            const submit = document.getElementById('passwordSubmit');

            form?.addEventListener('submit', () => {
                if (!submit) {
                    return;
                }

                submit.disabled = true;
                submit.classList.add('opacity-60', 'cursor-not-allowed');
                submit.textContent = 'Updating...';
            });
        });
    </script>
@endpush
