<x-app-layout>
    <body>
        <h2>Mypage</h2>
        <h2>{{$user->name}}</h2>
        <h2>Favorite World</h2>
        @foreach ($favorite_worlds as $world)
            @if($world)
            <div class='post'>
                <h2 class='title'>{{ $world->name }}</h2>
                <p>
                    <img src="{{ $world->imageUrl }}" width ="20%">
                </p>
                <a href="/worlds/{{$world->id}}">go</a>
            </div>
            @endif
        @endforeach

        <h2>Visited World</h2>
        @foreach ($visited_worlds as $world)
            @if($world)
            <div class='post'>
                <h2 class='title'>{{ $world->name }}</h2>
                <p>
                    <img src="{{ $world->imageUrl }}" width ="20%">
                </p>
                <a href="/worlds/{{$world->id}}">go</a>
            </div>
            @endif
        @endforeach
        <a href="/">return</a>
    </body>
</x-app-layout>