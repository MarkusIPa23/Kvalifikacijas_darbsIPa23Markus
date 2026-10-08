<?php

namespace App\Policies;

use App\Models\GameComment;
use App\Models\User;

class GameCommentPolicy
{
    public function update(User $user, GameComment $gameComment): bool
    {
        return $user->id === $gameComment->user_id;
    }

    public function delete(User $user, GameComment $gameComment): bool
    {
        return $user->id === $gameComment->user_id;
    }
}
