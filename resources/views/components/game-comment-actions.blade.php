@can('update', $comment)
    <div class="comment-tools">
        <details class="comment-edit">
            <summary>Rediģēt</summary>
            <form action="{{ route('games.comments.update', $comment) }}" method="POST" class="comment-edit-form">
                @csrf
                @method('PATCH')
                <textarea name="body" rows="2" minlength="2" maxlength="500" required>{{ $comment->body }}</textarea>
                <button type="submit">Saglabāt</button>
            </form>
        </details>
        <form action="{{ route('games.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Vai tiešām dzēst šo komentāru?')">
            @csrf
            @method('DELETE')
            <button class="comment-delete-button" type="submit">Dzēst</button>
        </form>
    </div>
@endcan