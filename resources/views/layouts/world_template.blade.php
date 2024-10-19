<div class='post'>
    <h2 class='title'>{{ $world->name }}</h2>
    <p>
        <img src="{{ $world->imageUrl }}" width ="20%">
    </p>
    <h2 class='title'>{{ $world->favorites }}</h2>
    <a href="/worlds/{{ $world->id }}">go</a>


    @if (Auth::user())
        <form action="/users/{{ Auth::user()->id }}/favorite/{{ $world->id }}" method="POST">
            @csrf
            <input type="submit" value="favorite" />
        </form>
        <form action="/users/{{ Auth::user()->id }}/favorite/{{ $world->id }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" value="delete" />
        </form>

        <form action="/users/{{ Auth::user()->id }}/visited/{{ $world->id }}" method="POST">
            @csrf
            <input type="submit" value="visited" />
        </form>
        <form action="/users/{{ Auth::user()->id }}/visited/{{ $world->id }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" value="delete" />
        </form>
    @endif
</div>
