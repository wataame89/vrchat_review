<x-app-layout>

    <body>
        <div class="mx-16 my-8 px-24 py-12 rounded bg-gray-100 text-gray-700">
            <div class="font-bold text-4xl m-2">
                {{ $world->name }}
                <div class="font-normal inline-block text-base">
                    by {{ $world->authorName }}
                </div>
            </div>
            <div class="flex ml-5">
                <div class="text-gray-700 text-2xl m-1">
                    <div class="flex">
                        <div class="text-gray-700 text-2xl flex items-center justify-between" style="width:120px">
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
                    <div class="text-xl">
                        In VRChat 🧡{{ $world->favorites }}
                    </div>
                </div>
                @auth
                    <div class="text-center">
                        <div class="inline-block mx-2 text-4xl cursor-pointer">
                            @if ($virtualWorld->isFavoritedByAuthUser($world->id))
                                {{-- こちらがいいね済の際に表示される方で、likedクラスが付与してあることで星に色がつきます --}}
                                <i class="fa-solid fa-heart favorite-btn text-red-500" id={{ $world->id }}
                                    data-user-id={{ Auth::user()->id }}></i>
                            @else
                                <i class="fa-solid fa-heart favorite-btn" id={{ $world->id }}
                                    data-user-id={{ Auth::user()->id }}></i>
                            @endif
                            <p class="text-base">{{ $virtualWorld->getFavoriteWorlds($world->id)->count() }}</p>
                        </div>

                        <div class="inline-block mx-2 text-4xl cursor-pointer">
                            @if ($virtualWorld->isVisitedByAuthUser($world->id))
                                {{-- こちらがいいね済の際に表示される方で、likedクラスが付与してあることで星に色がつきます --}}
                                <i class="fa-solid fa-location-dot text-4xl visited-btn text-blue-500"
                                    id={{ $world->id }} data-user-id={{ Auth::user()->id }}></i>
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
            </div>
            <div class="flex">
                <div class="w-1/3 text-center">
                    <div class="">
                        <a href="https://vrchat.com/home/world/{{ $world->id }}" target="_blank"
                            rel="noopener noreferrer">
                            <img class="rounded w-full m-2" src="{{ $world->imageUrl }}" alt="{{ $world->name }}">
                            {{-- <p class="text-gray-700 text-sm">
                    author : {{ $world->authorName }}
                </p> --}}
                        </a>
                    </div>

                    <a href="https://vrchat.com/home/world/{{ $world->id }}" target="_blank"
                        rel="noopener noreferrer"
                        class="inline-block py-2 px-16 items-center justify-center align-middle font-bold text-lg rounded-md border border-gray-200 bg-white hover:bg-gray-100 cursor-pointer active:bg-gray-300 focus:outline-none">
                        Open in VRChat
                    </a>
                </div>
                <div class="w-2/3 overflow-hidden m-2 ml-8">
                    <div class="font-bold text-2xl">Description</div>
                    <div class=''>{{ $world->description }}</div>
                    <div class="font-bold text-2xl">capacity</div>
                    <div class=''>{{ $world->capacity }}</div>
                    <div class="font-bold text-2xl">created_at</div>
                    <div class=''>{{ $world->created_at }}</div>
                    <div class="font-bold text-2xl">updated_at</div>
                    <div class=''>{{ $world->updated_at }}</div>

                    <div class="w-full rounded overflow-hidden m-2">
                        <div class="font-bold text-2xl">
                            tag:
                            @foreach ($world->tags as $tag)
                                @if (Str::contains($tag, 'author_tag_'))
                                    <span
                                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold mr-2 mb-2">
                                        {{ Str::after($tag, 'author_tag_') }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center text-2xl font-bold m-4">Reviews</div>
            <div class="flex flex-wrap justify-center">
                @if ($reviews)
                    @foreach ($reviews as $review)
                        <div class="relative p-2 w-80 min-h-60 rounded overflow-hidden shadow-lg m-2 bg-white">
                            <div class="flex">
                                <div class="font-bold text-base m-2">{{ $review->username }}</div>


                                <div class="absolute right-0 m-2" x-data="{ open: false }">
                                    <!-- 三点リーダーのアイコン -->
                                    <button @click="open = !open"
                                        class="p-2 rounded-full hover:bg-gray-200 focus:outline-none">
                                        <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 16a2 2 0 110 4 2 2 0 010-4zm0-6a2 2 0 110 4 2 2 0 010-4zm0-6a2 2 0 110 4 2 2 0 010-4z" />
                                        </svg>
                                    </button>

                                    <!-- メニューの内容 -->
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute right-0 m-2 w-24 bg-white rounded-md shadow-lg z-20">
                                        {{-- x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"> --}}
                                        <a href="/reviews/{{ $world->id }}/{{ $review->id }}/edit"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                        <form action="/reviews/{{ $review->id }}" id="form_{{ $review->id }}"
                                            method="post"class="block px-4 py-2 m-0 text-sm text-gray-700 hover:bg-gray-100">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="world_id" value="{{ $world->id }}">
                                            <button type="button"
                                                onclick="deletePost({{ $review->id }})">Delete</button>
                                        </form>
                                        <a href="#"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Report</a>
                                    </div>
                                </div>
                            </div>
                            <div class="font-bold underline text-xl m-2">{{ $review->title }}</div>

                            <div class="flex">
                                <div class="text-gray-700 text-2xl m-1 flex items-center justify-between"
                                    style="width:120px">
                                    <span class="absolute inline-block h-8 text-gray-500" style="width:120px">
                                        ★★★★★
                                    </span>
                                    <span class="relative inline-block h-8" style="width:120px">
                                    </span>
                                    <span class="absolute inline-block h-8 overflow-hidden text-orange-300"
                                        style="width:{{ $review->rank * 24 }}px">
                                        ★★★★★
                                    </span>
                                </div>
                                {{-- <div class="text-2xl m-1">
                                    {{ $review->rank }}
                                </div> --}}
                            </div>
                            <div class='m-2'>{{ $review->body }}</div>
                            <div class='m-2'>写真</div>

                        </div>
                    @endforeach
                @endif
                <a href="/reviews/{{ $world->id }}/create"
                    class="p-2 w-80 rounded overflow-hidden shadow-lg m-2 bg-white">
                    <div class="flex items-center justify-center h-full">
                        <div class="font-bold text-xl">口コミを投稿する</div>
                    </div>
                </a>
            </div>
        </div>
    </body>

    <script>
        function deletePost(id) {
            'use strict'

            if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                document.getElementById(`form_${id}`).submit();
            }
        }
    </script>
</x-app-layout>
