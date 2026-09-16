<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Customize your profile') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Add a little personality and choose what other players can see.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <input type="hidden" name="name" value="{{ $user->name }}">
        <input type="hidden" name="email" value="{{ $user->email }}">

        <div>
            <x-input-label for="bio" :value="__('Short bio')" />
            <textarea id="bio" name="bio" rows="3" maxlength="500" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('bio', $user->bio) }}</textarea>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('Up to 500 characters.') }}</p>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div>
            <x-input-label for="avatar_url" :value="__('Avatar image URL')" />
            <x-text-input id="avatar_url" name="avatar_url" type="url" class="mt-1 block w-full" :value="old('avatar_url', $user->avatar_url)" placeholder="https://example.com/avatar.jpg" />
            <x-input-error class="mt-2" :messages="$errors->get('avatar_url')" />
        </div>

        <div>
            <x-input-label for="favorite_genre" :value="__('Favorite genre')" />
            <select id="favorite_genre" name="favorite_genre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                <option value="">{{ __('Choose a genre') }}</option>
                @foreach (['Action', 'Adventure', 'Puzzle', 'RPG', 'Simulation', 'Strategy', 'Sports'] as $genre)
                    <option value="{{ $genre }}" @selected(old('favorite_genre', $user->favorite_genre) === $genre)>{{ __($genre) }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('favorite_genre')" />
        </div>

        <fieldset>
            <legend class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Profile accent') }}</legend>
            <div class="mt-3 grid grid-cols-4 gap-3">
                @foreach ([
                    'teal' => 'bg-teal-600',
                    'coral' => 'bg-rose-500',
                    'amber' => 'bg-amber-500',
                    'sky' => 'bg-sky-500',
                ] as $color => $swatch)
                    <label class="flex cursor-pointer items-center justify-center rounded-md border p-3 transition hover:border-gray-500 dark:border-gray-600">
                        <input type="radio" name="profile_color" value="{{ $color }}" class="peer sr-only" @checked(old('profile_color', $user->profile_color) === $color)>
                        <span class="h-7 w-7 rounded-full {{ $swatch }} ring-2 ring-transparent ring-offset-2 peer-checked:ring-gray-900"></span>
                        <span class="sr-only">{{ ucfirst($color) }}</span>
                    </label>
                @endforeach
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_color')" />
        </fieldset>

        <div class="space-y-4">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <x-input-label for="profile_visibility" :value="__('Public profile')" />
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Let other players discover your profile.') }}</p>
                </div>
                <div>
                    <input type="hidden" name="profile_visibility" value="0">
                    <input id="profile_visibility" name="profile_visibility" type="checkbox" value="1" class="rounded border-gray-300 text-teal-600 shadow-sm focus:ring-teal-500" @checked(old('profile_visibility', $user->profile_visibility))>
                </div>
            </div>

            <div class="flex items-center justify-between gap-4">
                <div>
                    <x-input-label for="show_favorites" :value="__('Show favorite games')" />
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Display your favorites on your public profile.') }}</p>
                </div>
                <div>
                    <input type="hidden" name="show_favorites" value="0">
                    <input id="show_favorites" name="show_favorites" type="checkbox" value="1" class="rounded border-gray-300 text-teal-600 shadow-sm focus:ring-teal-500" @checked(old('show_favorites', $user->show_favorites))>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save customization') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>