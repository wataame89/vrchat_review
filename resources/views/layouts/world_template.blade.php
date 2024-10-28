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
        <div class="text-gray-700 text-2xl m-1 flex items-center justify-between" style="width:120px">
            <span class="absolute inline-block h-8 text-gray-500" style="width:120px">
                ★★★★★
            </span>
            <span class="relative inline-block h-8" style="width:120px">
            </span>
            <span class="absolute inline-block h-8 overflow-hidden text-orange-300"
                style="width:{{ $review->getAverageRank($world->id) * 24 }}px">
                ★★★★★
            </span>
        </div>
        <div class="text-2xl m-1">
            {{ $review->getAverageRank($world->id) }}
        </div>
    </div>
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
                <div class="text-base">{{ $virtualWorld->getFavoriteWorlds($world->id)->count() }}</div>
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
                <div class="text-base">{{ $virtualWorld->getVisitedWorlds($world->id)->count() }}</div>
            </div>

            <a href="/reviews/{{ $world->id }}/create" class="inline-block mx-2 text-4xl cursor-pointer">
                @if ($review->isReviewedByAuthUser($world->id))
                    {{-- こちらがいいね済の際に表示される方で、likedクラスが付与してあることで星に色がつきます --}}
                    <i class="fa-solid fa-comment text-4xl review-btn text-green-500"></i>
                @else
                    <i class="fa-solid fa-comment text-4xl review-btn"></i>
                @endif
                <div class="text-base">{{ $review->getWorldReviews($world->id)->count() }}</div>
            </a>
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
