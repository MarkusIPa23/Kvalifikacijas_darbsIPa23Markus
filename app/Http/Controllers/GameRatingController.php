<?php

namespace App\Http\Controllers;

use App\Models\GameRating;
use App\Services\RawgGameService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GameRatingController extends Controller
{
    public function store(Request $request, int $gameId, RawgGameService $rawgGameService): RedirectResponse
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,10'],
            'game_title' => ['nullable', 'string', 'max:255'],
        ]);

        if (! $rawgGameService->exists($gameId)) {
            throw ValidationException::withMessages([
                'gameId' => 'Šī spēle RAWG katalogā nav atrasta.',
            ]);
        }

        GameRating::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'game_id' => (string) $gameId,
            ],
            [
                'game_title' => $validated['game_title'] ?? null,
                'rating' => $validated['rating'],
            ],
        );

        return redirect()->back();
    }
}
