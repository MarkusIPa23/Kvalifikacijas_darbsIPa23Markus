<section class="profile-manager-section">
    <header class="profile-card-header">
        <div>
            <p class="eyebrow">PLAYER PROFILE</p>
            <h2>{{ __('Customize your profile') }}</h2>
        </div>
        <p>{{ __('Add personality, set your vibe, and help other players discover your style.') }}</p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="profile-form">
        @csrf
        @method('patch')
        <input type="hidden" name="name" x-bind:value="previewName">
        <input type="hidden" name="email" value="{{ $user->email }}">

        <div class="profile-option-grid">
            <div class="profile-field profile-field-full">
                <x-input-label for="bio" :value="__('Short bio')" />
                <textarea id="bio" name="bio" rows="4" maxlength="500" class="profile-input" x-model="previewBio">{{ old('bio', $user->bio) }}</textarea>
                <p class="profile-field-note"><span x-text="previewBio.length"></span>/500 {{ __('characters') }}</p>
                <x-input-error class="mt-2" :messages="$errors->get('bio')" />
            </div>

            <div class="profile-field">
                <x-input-label for="avatar_url" :value="__('Avatar image URL')" />
                <x-text-input id="avatar_url" name="avatar_url" type="url" class="profile-input" x-model="previewAvatar" placeholder="https://example.com/avatar.jpg" />
                <x-input-error class="mt-2" :messages="$errors->get('avatar_url')" />
            </div>

            <div class="profile-field">
                <x-input-label for="favorite_genre" :value="__('Favorite genre')" />
                <select id="favorite_genre" name="favorite_genre" class="profile-input">
                    <option value="">{{ __('Choose a genre') }}</option>
                    @foreach (['Action', 'Adventure', 'Puzzle', 'RPG', 'Simulation', 'Strategy', 'Sports'] as $genre)
                        <option value="{{ $genre }}" @selected(old('favorite_genre', $user->favorite_genre) === $genre)>{{ __($genre) }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('favorite_genre')" />
            </div>

            <div class="profile-field">
                <x-input-label for="preferred_platform" :value="__('Preferred platform')" />
                <select id="preferred_platform" name="preferred_platform" class="profile-input">
                    <option value="">{{ __('Pick your setup') }}</option>
                    @foreach (['PC', 'PlayStation', 'Xbox', 'Switch', 'Mobile', 'VR'] as $platform)
                        <option value="{{ $platform }}" @selected(old('preferred_platform', $user->preferred_platform) === $platform)>{{ $platform }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('preferred_platform')" />
            </div>

            <div class="profile-field">
                <x-input-label for="play_style" :value="__('Play style')" />
                <select id="play_style" name="play_style" class="profile-input">
                    <option value="">{{ __('Choose your vibe') }}</option>
                    @foreach (['Casual', 'Competitive', 'Co-op', 'Story-first', 'Challenge runs'] as $style)
                        <option value="{{ $style }}" @selected(old('play_style', $user->play_style) === $style)>{{ $style }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('play_style')" />
            </div>

            <div class="profile-field">
                <x-input-label for="gaming_status" :value="__('Gaming status')" />
                <select id="gaming_status" name="gaming_status" class="profile-input">
                    <option value="">{{ __('Select a status') }}</option>
                    @foreach (['Looking for squad', 'Ready to compete', 'Chill vibes', 'Exploring games'] as $status)
                        <option value="{{ $status }}" @selected(old('gaming_status', $user->gaming_status) === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('gaming_status')" />
            </div>
        </div>

        <fieldset class="profile-accent-block">
            <legend>{{ __('Profile accent') }}</legend>
            <div class="profile-accent-grid">
                @foreach ([
                    'teal' => 'bg-teal-600',
                    'coral' => 'bg-rose-500',
                    'amber' => 'bg-amber-500',
                    'sky' => 'bg-sky-500',
                ] as $color => $swatch)
                    <label class="profile-swatch-option">
                        <input type="radio" name="profile_color" value="{{ $color }}" class="peer sr-only" x-model="previewColor" @checked(old('profile_color', $user->profile_color) === $color)>
                        <span class="profile-swatch {{ $swatch }}"></span>
                        <span class="sr-only">{{ ucfirst($color) }}</span>
                    </label>
                @endforeach
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_color')" />
        </fieldset>

        <div class="profile-toggle-list">
            <div class="profile-toggle-row">
                <div>
                    <x-input-label for="profile_visibility" :value="__('Public profile')" />
                    <p>{{ __('Let other players discover your profile.') }}</p>
                </div>
                <div>
                    <input type="hidden" name="profile_visibility" value="0">
                    <input id="profile_visibility" name="profile_visibility" type="checkbox" value="1" class="profile-toggle" @checked(old('profile_visibility', $user->profile_visibility))>
                </div>
            </div>

            <div class="profile-toggle-row">
                <div>
                    <x-input-label for="show_favorites" :value="__('Show favorite games')" />
                    <p>{{ __('Display your favorites on your public profile.') }}</p>
                </div>
                <div>
                    <input type="hidden" name="show_favorites" value="0">
                    <input id="show_favorites" name="show_favorites" type="checkbox" value="1" class="profile-toggle" @checked(old('show_favorites', $user->show_favorites))>
                </div>
            </div>
        </div>

        <div class="profile-form-actions">
            <x-primary-button>{{ __('Save customization') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p class="profile-save-status">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>