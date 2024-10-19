<x-app-layout>
    <body>
        <form action="/reviews" method="POST">
            @csrf
            <div class="rank">
                <h2>Rank</h2>
                <input type="number" name="review[rank]" placeholder="3"/>
            </div>
            <div class="title">
                <h2>Title</h2>
                <input type="text" name="review[title]" placeholder="タイトル" value="{{ old('review.title') }}"/>
                <p class="title__error" style="color:red">{{ $errors->first('review.title') }}</p>
            </div>
            <div class="body">
                <h2>Body</h2>
                <textarea name="review[body]" placeholder="きれいなワールドです。">{{ old('review.body') }}</textarea>
                <p class="title__error" style="color:red">{{ $errors->first('review.body') }}</p>
            </div>
            <input type="hidden" name="review[user_id]" value="{{Auth::user()->id}}">
            <input type="hidden" name="review[world_id]" value="{{$world_id}}">
            <input type="submit" value="投稿"/>
        </form>
        <a href="/">return</a>
    </body>
</x-app-layout>