<script>
    window.FutureGamesApi = {
        async list(filters = {}, { signal } = {}) {
            const url = new URL(@json(route('future.games', [], false)), window.location.origin);

            Object.entries(filters).forEach(([key, value]) => {
                if (Array.isArray(value)) {
                    value.forEach((item) => url.searchParams.append(`${key}[]`, item));
                } else if (value !== null && value !== undefined && value !== '') {
                    url.searchParams.set(key, value);
                }
            });

            let response;
            try {
                response = await fetch(url, {
                    headers: { Accept: 'application/json' },
                    signal,
                });
            } catch (error) {
                if (error.name === 'AbortError') {
                    throw error;
                }

                throw new Error('Neizdevās sazināties ar RAWG katalogu.');
            }
            const payload = await response.json().catch(() => ({}));

            if (!response.ok) {
                throw new Error(payload.message ?? 'Spēļu katalogs pašlaik nav pieejams.');
            }

            if (!Array.isArray(payload.data)) {
                throw new Error('RAWG katalogs atgrieza nederīgus datus.');
            }

            return payload.data;
        },
        detailUrl(gameId) {
            return @json(route('games.show', ['gameId' => '__GAME_ID__'], false))
                .replace('__GAME_ID__', encodeURIComponent(gameId));
        },
    };
</script>