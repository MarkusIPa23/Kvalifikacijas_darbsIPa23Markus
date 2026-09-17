<x-app-layout>
    @php
        $profileGradient = match ($user->profile_color) {
            'coral' => 'from-rose-600 via-fuchsia-600 to-purple-700',
            'amber' => 'from-amber-500 via-orange-600 to-rose-600',
            'sky' => 'from-indigo-600 via-blue-600 to-cyan-600',
            default => 'from-purple-700 via-violet-600 to-indigo-700',
        };
    @endphp

    @php
        $profileCompletionFields = [
            $user->name,
            $user->email,
            $user->bio,
            $user->avatar_url,
            $user->favorite_genre,
            $user->preferred_platform,
            $user->play_style,
            $user->gaming_status,
        ];
        $profileCompletion = (int) round(collect($profileCompletionFields)->filter()->count() / count($profileCompletionFields) * 100);
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

    <div
        class="profile-page"
        x-data="{
            previewName: @js(old('name', $user->name)),
            previewBio: @js(old('bio', $user->bio ?? '')),
            previewAvatar: @js(old('avatar_url', $user->avatar_url ?? '')),
            previewColor: @js(old('profile_color', $user->profile_color ?? 'teal'))
        }"
    >
        <div class="profile-shell">
            <div class="profile-hero {{ $profileGradient }}">
                <div class="profile-hero-inner">
                    <div class="profile-hero-profile">
                        <div class="profile-avatar">
                            @if ($user->avatar_url)
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                            @else
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <p class="profile-kicker">{{ __('Welcome back') }}</p>
                            <h1>{{ $user->name }}</h1>
                            <p class="profile-subtitle">{{ $user->favorite_genre ?: __('Game explorer') }}</p>
                        </div>
                    </div>

                    <div class="profile-hero-stats">
                        <div class="profile-stat">
                            <strong>{{ count($user->favorite_games ?? []) }}</strong>
                            <span>{{ __('Favorites') }}</span>
                        </div>
                        <div class="profile-stat">
                            <strong>{{ $user->profile_visibility ? __('On') : __('Off') }}</strong>
                            <span>{{ __('Public profile') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-layout">
                <div class="profile-main-column">
                    <div class="profile-panel">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div class="profile-panel">
                        @include('profile.partials.customize-profile-form')
                    </div>
                </div>

                <aside class="profile-sidebar">
                    <div class="profile-panel profile-preview-card">
                        <div class="profile-sidebar-header">
                            <p class="eyebrow">LIVE PREVIEW</p>
                            <h3>{{ __('Your player card') }}</h3>
                        </div>
                        <div class="profile-preview" :class="`profile-preview-${previewColor}`">
                            <div class="profile-preview-avatar">
                                <img x-show="previewAvatar" :src="previewAvatar" :alt="previewName" class="h-full w-full object-cover">
                                <span x-show="!previewAvatar" x-text="(previewName || 'P').charAt(0).toUpperCase()"></span>
                            </div>
                            <div class="profile-preview-copy">
                                <strong x-text="previewName || 'Player name'"></strong>
                                <span x-text="previewBio || 'Add a short bio to introduce yourself.'"></span>
                            </div>
                        </div>
                        <div class="profile-completion">
                            <div class="profile-completion-heading">
                                <span>{{ __('Profile completeness') }}</span>
                                <strong>{{ $profileCompletion }}%</strong>
                            </div>
                            <div class="profile-progress" role="progressbar" aria-label="Profile completeness" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $profileCompletion }}">
                                <span style="width: {{ $profileCompletion }}%"></span>
                            </div>
                            <p>{{ __('Complete the essentials so other players know what you enjoy.') }}</p>
                        </div>
                    </div>

                    <div class="profile-panel profile-sidebar-card">
                        <div class="profile-sidebar-header">
                            <p class="eyebrow">STATUS</p>
                            <h3>{{ __('Player overview') }}</h3>
                        </div>
                        <ul class="profile-mini-list">
                            <li>
                                <span>{{ __('Favorite genre') }}</span>
                                <strong>{{ $user->favorite_genre ?: __('Not chosen') }}</strong>
                            </li>
                            <li>
                                <span>{{ __('Platform') }}</span>
                                <strong>{{ $user->preferred_platform ?: __('Not chosen') }}</strong>
                            </li>
                            <li>
                                <span>{{ __('Play style') }}</span>
                                <strong>{{ $user->play_style ?: __('Not chosen') }}</strong>
                            </li>
                            <li>
                                <span>{{ __('Status') }}</span>
                                <strong>{{ $user->gaming_status ?: __('Not chosen') }}</strong>
                            </li>
                        </ul>
                    </div>

                    <div class="profile-panel profile-sidebar-card">
                        <div class="profile-sidebar-header">
                            <p class="eyebrow">QUICK TOOLS</p>
                            <h3>{{ __('Profile tools') }}</h3>
                        </div>
                        <div class="profile-tool-list">
                            <span>{{ __('Public profile') }}: {{ $user->profile_visibility ? __('On') : __('Off') }}</span>
                            <span>{{ __('Favorites shared') }}: {{ $user->show_favorites ? __('Yes') : __('No') }}</span>
                            <span>{{ __('Accent') }}: {{ ucfirst($user->profile_color ?? 'teal') }}</span>
                        </div>
                    </div>

                    <div class="profile-panel profile-sidebar-card danger-panel">
                        @include('profile.partials.delete-user-form')
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
