<x-app-layout>
    <body>
    <main>
        @foreach ($worlds as $world)
            <div class='post'>
                <h2 class='title'>{{ $world->name }}</h2>
                <p>
                    <img src="{{ $world->imageUrl }}" width ="20%">
                </p>
                <a href="/worlds/{{$world->id}}">go</a>
            </div>
        @endforeach
        <a href="/">return</a>
    </main>
    </body>
</x-app-layout>