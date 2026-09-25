<form action="{{ route('community.review') }}" method="POST">
    @csrf

    <label>Selecciona un juego</label>
    <select name="game_id" required class="select-box">
        @foreach($games as $game)
        <option value="{{ $game->id }}">{{ $game->title }}</option>
        @endforeach
    </select>

    <label>Calificación</label>
    <div class="stars">
        @for($i = 5; $i >= 1; $i--)
        <label>
            <input type="radio" name="rating" value="{{ $i }}" required>
            {{ str_repeat('⭐', $i) }}
        </label>
        @endfor
    </div>

    <textarea name="review" class="content-box" required placeholder="Escribe tu reseña..."></textarea>

    <button class="send-btn">Publicar Reseña</button>
</form>