<?php

namespace App\Http\Controllers;

use App\Models\GameComment;
use App\Services\RawgGameService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GameCommentController extends Controller
{
    public function store(Request $request, int $gameId, RawgGameService $rawgGameService): RedirectResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'min:2', 'not_regex:/^\s*$/', 'max:500'],
            'game_title' => ['nullable', 'string', 'max:255'],
        ]);

        if (! $rawgGameService->exists($gameId)) {
            throw ValidationException::withMessages([
                'gameId' => 'Šī spēle RAWG katalogā nav atrasta.',
            ]);
        }

        GameComment::create([
            'user_id' => $request->user()->id,
            'game_id' => (string) $gameId,
            'game_title' => $validated['game_title'] ?? null,
            'body' => trim($validated['body']),
        ]);

        return redirect()->back();
    }
}
