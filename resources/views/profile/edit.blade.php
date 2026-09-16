<x-app-layout>
    @php
        $profileGradient = match ($user->profile_color) {
            'coral' => 'from-rose-600 via-orange-600 to-amber-600',
            'amber' => 'from-amber-600 via-yellow-600 to-orange-600',
            'sky' => 'from-sky-600 via-cyan-600 to-blue-600',
            default => 'from-teal-700 via-cyan-700 to-sky-700',
        };
    @endphp

    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-widest text-teal-600 dark:text-teal-400">{{ __('Account studio') }}</p>
                <h2 class="text-2xl font-semibold leading-tight text-gray-900 dark:text-gray-100">{{ __('Your profile') }}</h2>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Make it feel like yours.') }}</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-xl bg-gradient-to-r {{ $profileGradient }} shadow-lg">
                <div class="flex flex-col gap-6 p-6 text-white sm:flex-row sm:items-center sm:justify-between sm:p-8">
                    <div class="flex items-center gap-5">
                        <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-full border-4 border-white/30 bg-white/20 text-2xl font-bold">
                            @if ($user->avatar_url)
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                            @else
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-medium text-cyan-100">{{ __('Welcome back') }}</p>
                            <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                            <p class="mt-1 text-sm text-cyan-100">{{ $user->favorite_genre ?: __('Game explorer') }}</p>
                        </div>
                    </div>
                    <div class="flex gap-8 text-sm">
                        <div>
                            <p class="text-2xl font-bold">{{ count($user->favorite_games ?? []) }}</p>
                            <p class="text-cyan-100">{{ __('Favorites') }}</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold">{{ $user->profile_visibility ? __('On') : __('Off') }}</p>
                            <p class="text-cyan-100">{{ __('Public profile') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.customize-profile-form')
                </div>
            </div>

            <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
