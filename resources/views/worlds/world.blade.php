<x-app-layout>

    <body>
        @include('layouts.world_template')
        <h2 class='title'>{{ $world->description }}</h2>
        <h2 class='title'>{{ $world->authorName }}</h2>
        @if ($reviews)
            @foreach ($reviews as $review)
                <div class='review'>
                    <p>
                        {{ $review->rank }}
                    </p>
                    <h2 class='title'>{{ $review->title }}</h2>
                    <p>
                        {{ $review->body }}
                    </p>
                </div>
                <a href="/reviews/{{ $world->id }}/{{ $review->id }}/edit">edit</a>
                <form action="/reviews/{{ $review->id }}" id="form_{{ $review->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="world_id" value="{{ $world->id }}">
                    <button type="button" onclick="deletePost({{ $review->id }})">delete</button>
                </form>
            @endforeach
        @endif
        <a href="/reviews/{{ $world->id }}/create">口コミを投稿する</a>
        <a href="/">return</a>
    </body>
    <script>
        function deletePost(id) {
            'use strict'

            if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                document.getElementById(`form_${id}`).submit();
            }
        }
    </script>
</x-app-layout>
