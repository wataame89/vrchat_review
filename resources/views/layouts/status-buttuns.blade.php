@auth
    <div class="text-center">
        <div class="inline-block mx-2 text-4xl cursor-pointer">
            @if ($virtualWorld->isFavoritedByAuthUser($world->id))
                {{-- こちらがいいね済の際に表示される方で、likedクラスが付与してあることで星に色がつきます --}}
                <i class="fa-solid fa-heart favorite-btn text-red-500" id={{ $world->id }}
                    data-user-id={{ Auth::user()->id }}></i>
            @else
                <i class="fa-solid fa-heart favorite-btn" id={{ $world->id }} data-user-id={{ Auth::user()->id }}></i>
            @endif
            <p class="text-base">{{ $virtualWorld->getFavoriteWorlds($world->id)->count() }}</p>
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
            <p class="text-base">{{ $virtualWorld->getVisitedWorlds($world->id)->count() }}</p>
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
