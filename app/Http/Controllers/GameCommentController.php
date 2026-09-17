<?php

namespace App\Http\Controllers;

use App\Models\GameComment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GameCommentController extends Controller
{
    public function store(Request $request, int $gameId): RedirectResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'min:2', 'max:500'],
            'game_title' => ['nullable', 'string', 'max:255'],
        ]);

        GameComment::create([
            'user_id' => $request->user()->id,
            'game_id' => (string) $gameId,
            'game_title' => $validated['game_title'] ?? null,
            'body' => trim($validated['body']),
        ]);

        return redirect()->back();
    }
}
