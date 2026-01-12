<x-layouts.app>
    <section class="bg-slate-900 text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-semibold">Profile</h1>
            <p class="mt-2 text-sm text-slate-300">Keep your personal information up to date so we can serve you faster.</p>
        </div>
    </section>

    <section class="container mx-auto px-4 py-12">
        <div class="grid gap-8 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-card>
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900">Account details</h2>
                        <a href="{{ route('account.password.edit') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Change password</a>
                    </div>

                    @if(session('status'))
                        <div class="mt-6">
                            <x-alert type="success">{{ session('status') }}</x-alert>
                        </div>
                    @endif

                    <form id="profileForm" method="POST" action="{{ route('account.profile.update') }}" class="mt-6 space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700">Full name</label>
                            <x-input id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Jane Doe" />
                            @error('name')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                            <x-input id="email" name="email" value="{{ $user->email }}" readonly class="cursor-not-allowed" />
                            <p class="mt-1 text-xs text-slate-500">Email is managed through your account settings.</p>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-slate-700">Phone</label>
                            <x-input id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+966 5xx xxx xxxx" />
                            @error('phone')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label for="city" class="block text-sm font-medium text-slate-700">City</label>
                                <x-input id="city" name="city" value="{{ old('city', $user->city) }}" placeholder="Riyadh" />
                                @error('city')
                                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="district" class="block text-sm font-medium text-slate-700">District</label>
                                <x-input id="district" name="district" value="{{ old('district', $user->district) }}" placeholder="Olaya" />
                                @error('district')
                                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="street" class="block text-sm font-medium text-slate-700">Street address</label>
                            <x-input id="street" name="street" value="{{ old('street', $user->street) }}" placeholder="123 Main St" />
                            @error('street')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="zip" class="block text-sm font-medium text-slate-700">ZIP / Postal code</label>
                            <x-input id="zip" name="zip" value="{{ old('zip', $user->zip) }}" placeholder="11564" />
                            @error('zip')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="text-right">
                            <button id="profileSubmit" type="submit" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold uppercase tracking-[0.3em] text-white transition hover:bg-slate-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-950" data-label="Save changes">
                                Save changes
                            </button>
                        </div>
                    </form>
                </x-card>
            </div>
            <div class="space-y-4">
                <x-card>
                    <h3 class="text-lg font-semibold text-slate-900">Need help?</h3>
                    <p class="mt-2 text-sm text-slate-600">Update your preferred contact details and receive faster support.</p>
                    <a href="{{ route('contact') }}" class="mt-4 inline-flex w-full items-center justify-center rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-500">Contact team</a>
                </x-card>
                <x-card>
                    <h3 class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-500">Security</h3>
                    <p class="mt-3 text-sm text-slate-600">Keep your password and two-factor controls up to date.</p>
                    <a href="{{ route('account.password.edit') }}" class="mt-4 inline-flex w-full items-center justify-center rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:border-slate-300">Change password</a>
                </x-card>
            </div>
        </div>
    </section>
</x-layouts.app>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('profileForm');
            const submit = document.getElementById('profileSubmit');

            form?.addEventListener('submit', () => {
                if (!submit) {
                    return;
                }

                submit.disabled = true;
                submit.classList.add('opacity-60', 'cursor-not-allowed');
                submit.textContent = 'Saving...';
            });
        });
    </script>
@endpush
