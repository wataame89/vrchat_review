@auth
    <div class="text-center">
        <div class="inline-block mx-2 text-4xl cursor-pointer">
            @if ($world_model->isFavoritedByAuthUser($world->id))
                {{-- こちらがいいね済の際に表示される方で、likedクラスが付与してあることで星に色がつきます --}}
                <i class="fa-solid fa-heart favorite-btn text-red-500 hover:scale-110 transition-transform duration-200"
                    id={{ $world->id }} data-user-id={{ Auth::user()->id }}></i>
            @else
                <i class="fa-solid fa-heart favorite-btn hover:scale-110 transition-transform duration-200"
                    id={{ $world->id }} data-user-id={{ Auth::user()->id }}></i>
            @endif
            <div class="text-base">{{ $world_model->getFavoriteWorlds($world->id)->count() }}</div>
        </div>

        <div class="inline-block mx-2 text-4xl cursor-pointer">
            @if ($world_model->isVisitedByAuthUser($world->id))
                {{-- こちらがいいね済の際に表示される方で、likedクラスが付与してあることで星に色がつきます --}}
                <i class="fa-solid fa-location-dot visited-btn text-blue-500 hover:scale-110 transition-transform duration-200"
                    id={{ $world->id }} data-user-id={{ Auth::user()->id }}></i>
            @else
                <i class="fa-solid fa-location-dot visited-btn hover:scale-110 transition-transform duration-200"
                    id={{ $world->id }} data-user-id={{ Auth::user()->id }}></i>
            @endif
            <div class="text-base">{{ $world_model->getVisitedWorlds($world->id)->count() }}</div>
        </div>

        {{-- <a href="/reviews/{{ $world->id }}/create" class="inline-block mx-2 text-4xl cursor-pointer"> --}}
        <div class="inline-block mx-2 text-4xl cursor-pointer">
            @if ($review_model->isReviewedByAuthUser($world->id))
                {{-- こちらがいいね済の際に表示される方で、likedクラスが付与してあることで星に色がつきます --}}
                <i class="fa-solid fa-comment text-green-500 hover:scale-110 transition-transform duration-200"></i>
            @else
                <div class="m-0">
                    <i class="fa-solid fa-comment review-btn hover:scale-110 transition-transform duration-200"
                        id={{ $world->id }}></i>
                </div>
            @endif
            <div class="text-base">{{ $review_model->getWorldReviews($world->id)->count() }}</div>
        </div>
        {{-- </a> --}}
    </div>
@endauth

@guest
    <div class="text-center">
        <a href="/register" class="inline-block mx-2 text-4xl cursor-pointer">
            <i class="fa-solid fa-heart hover:scale-110 transition-transform duration-200"></i>
            <div class="text-base">{{ $world_model->getFavoriteWorlds($world->id)->count() }}</div>
        </a>

        <a href="/register" class="inline-block mx-2 text-4xl cursor-pointer">
            <i class="fa-solid fa-location-dot hover:scale-110 transition-transform duration-200"></i>
            <div class="text-base">{{ $world_model->getVisitedWorlds($world->id)->count() }}</div>
        </a>

        {{-- <a href="/reviews/{{ $world->id }}/create" class="inline-block mx-2 text-4xl cursor-pointer"> --}}
        <a href="/register" class="inline-block mx-2 text-4xl cursor-pointer">
            <div class="m-0">
                <i class="fa-solid fa-comment hover:scale-110 transition-transform duration-200"></i>
            </div>
            <div class="text-base">{{ $review_model->getWorldReviews($world->id)->count() }}</div>
        </a>
        {{-- </a> --}}
    </div>
@endguest
