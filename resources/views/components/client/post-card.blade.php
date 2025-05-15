@props(['post', 'aspect' => '16/9', 'class' => '', 'showExcerpt' => false])

<a href="{{ route('client.posts.show', ['slug' => $post->slug]) }}" class="blog-wrapper {{ $class }}">
    <div class="ratio-box" style="aspect-ratio: {{ $aspect }};">
        <img src="{{ asset('storage/' . $post->preview_image) }}" alt="{{ $post->title }}" class="blog-image">
        <div class="blog-overlay"></div>
        <div class="blog-content">
            <div class="fw-bold">{{ $post->title }}</div>
            @if ($showExcerpt)
                <div class="small mt-1">{{ Str::limit($post->excerpt, 80) }}</div>
            @endif
        </div>
    </div>
</a>
