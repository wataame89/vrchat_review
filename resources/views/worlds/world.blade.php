<x-app-layout>
    <body>
        <h2 class='title'>{{ $world->name }}</h2>
            <p>
                <img src="{{ $world->imageUrl }}" width ="20%">
            </p>
            {{ $world->description }}
        
            <form action="/users/{{Auth::user()->id}}/favorite/{{$world->id}}" method="POST">
                @csrf
                <input type="submit" value="favorite"/>
            </form>
            <form action="/users/{{Auth::user()->id}}/favorite/{{$world->id}}" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" value="delete"/>
            </form>

            <form action="/users/{{Auth::user()->id}}/visited/{{$world->id}}" method="POST">
                @csrf
                <input type="submit" value="visited"/>
            </form>
            <form action="/users/{{Auth::user()->id}}/visited/{{$world->id}}" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" value="delete"/>
            </form>
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
                <a href="/reviews/{{$world->id}}/{{ $review->id }}/edit">edit</a>
                <form action="/reviews/{{ $review->id }}" id="form_{{ $review->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="world_id" value="{{$world->id}}">
                    <button type="button" onclick="deletePost({{ $review->id }})">delete</button> 
                </form>
            @endforeach
        @endif
        <a href="/reviews/{{$world->id}}/create">口コミを投稿する</a>
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