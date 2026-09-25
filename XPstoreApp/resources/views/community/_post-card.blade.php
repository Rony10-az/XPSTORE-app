<div class="post-card">

    <div class="post-user">
        <img src="{{ $post->user->avatar }}" alt="">
        <div>
            <h4>{{ $post->user->name }}</h4>
            <span class="time">{{ $post->created_at->diffForHumans() }}</span>
        </div>
    </div>

    <p class="post-text">{{ $post->content }}</p>

    @if($post->image)
    <img src="{{ asset('storage/'.$post->image) }}" class="post-image">
    @endif

    <div class="post-actions">
        <button>👍 {{ $post->likes->count() }}</button>
        <button>💬 {{ $post->comments->count() }}</button>
        <button>⭐</button>
    </div>

</div>