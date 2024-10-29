<div class="text-center w-80 rounded overflow-hidden shadow-lg m-2 bg-gray-100">
    <a href="/worlds/{{ $world->id }}">
        <img class="w-full" src="{{ $world->imageUrl }}" alt="{{ $world->name }}">
        <div class="font-bold text-xl m-2">{{ $world->name }}</div>
        {{-- <div class="text-gray-700 text-sm">
                author : {{ $world->authorName }}
            </div> --}}
    </a>
    <div class="text-gray-700 text-base m-1">
        In VRChat 🧡{{ $world->favorites }}
    </div>
    <div class="flex justify-center">
        @include('layouts.rank-star')
        <div class="text-2xl m-1">
            {{ $review->getAverageRank($world->id) }}
        </div>
    </div>
    <div class="mt-4">
        @include('layouts.status-buttuns')
    </div>

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
