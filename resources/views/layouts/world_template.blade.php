<div class="max-w-xs rounded overflow-hidden shadow-lg m-2">
    <a href="/worlds/{{ $world->id }}">
        <img class="w-full" src="{{ $world->imageUrl }}" alt="{{ $world->name }}">
        <div class="px-6 py-4">
            <div class="font-bold text-xl mb-2">{{ $world->name }}</div>
            {{-- <p class="text-gray-700 text-sm">
                author : {{ $world->authorName }}
            </p> --}}
            <p class="text-gray-700 text-base">
                🧡{{ $world->favorites }}
            </p>
            <p class="text-gray-700 text-base">
                ☆☆☆★★
            </p>
            <p class="text-gray-700 text-base">
                💭3
            </p>
        </div>
    </a>
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
    <div class="px-6 pt-4 pb-2">
        @foreach ($world->tags as $tag)
            @if (Str::contains($tag, 'author_tag_'))
                <span
                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                    {{ Str::after($tag, 'author_tag_') }}
                </span>
            @endif
        @endforeach
    </div>
</div>
