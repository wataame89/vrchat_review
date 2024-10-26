<div class="text-center max-w-xs rounded overflow-hidden shadow-lg m-2 bg-gray-100">
    <a href="/worlds/{{ $world->id }}">
        <img class="w-full" src="{{ $world->imageUrl }}" alt="{{ $world->name }}">
        <div class="font-bold text-xl m-2">{{ $world->name }}</div>
        {{-- <p class="text-gray-700 text-sm">
                author : {{ $world->authorName }}
            </p> --}}
    </a>
    <p class="text-gray-700 text-base m-1">
        In VRChat 🧡{{ $world->favorites }}
    </p>
    <p class="text-gray-700 text-2xl m-1">
        ☆☆☆★★
    </p>
    @auth
        <div class="mt-4">
            <div class="inline-block mx-2 text-4xl cursor-pointer">
                @if ($virtualWorld->isFavoritedByAuthUser($world->id))
                    {{-- こちらがいいね済の際に表示される方で、likedクラスが付与してあることで星に色がつきます --}}
                    <i class="fa-solid fa-heart favorite-btn text-red-500" id={{ $world->id }}
                        data-user-id={{ Auth::user()->id }}></i>
                @else
                    <i class="fa-solid fa-heart favorite-btn" id={{ $world->id }}
                        data-user-id={{ Auth::user()->id }}></i>
                @endif
                <p class="text-base">{{ $virtualWorld->favoriteWorlds($world->id)->count() }}</p>
            </div>

            <div class="inline-block mx-2 text-4xl cursor-pointer">
                @if ($virtualWorld->isVisitedByAuthUser($world->id))
                    {{-- こちらがいいね済の際に表示される方で、likedクラスが付与してあることで星に色がつきます --}}
                    <i class="fa-solid fa-location-dot text-4xl visited-btn text-blue-500" id={{ $world->id }}
                        data-user-id={{ Auth::user()->id }}></i>
                @else
                    <i class="fa-solid fa-location-dot text-4xl visited-btn" id={{ $world->id }}
                        data-user-id={{ Auth::user()->id }}></i>
                @endif
                <p class="text-base">{{ $virtualWorld->visitedWorlds($world->id)->count() }}</p>
            </div>

            <div class="inline-block mx-2 text-4xl cursor-pointer">
                <i class="fa-solid fa-comment text-4xl comment-btn text-green-500" id={{ $world->id }}
                    data-user-id={{ Auth::user()->id }}></i>
                <p class="text-base">0</p>
            </div>
        </div>
    @endauth

    @guest
    @endguest

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
