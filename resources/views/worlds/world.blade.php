<x-app-layout>

    <body>
        <div class="mx-24 my-8 px-24 py-12 rounded-lg bg-gray-100 text-gray-700">
            <div class="font-bold text-4xl m-2">
                {{ $world->name }}
                <div class="font-normal inline-block text-base">
                    by {{ $world->authorName }}
                </div>
            </div>
            <div class="flex ml-2">
                <div class="text-gray-700 text-2xl m-1">
                    <div class="flex">
                        @include('layouts.rank-star')
                        <div class="text-2xl m-1">
                            {{ $review->getAverageRank($world->id) }}
                        </div>
                    </div>
                    <div class="text-xl ml-2">
                        In VRChat 🧡{{ $world->favorites }}
                    </div>
                </div>
                <div class="mt-2 ml-4">
                    @include('layouts.status-buttuns')
                </div>
            </div>
            <div class="flex">
                <div class="w-1/3 text-center">
                    <div class="">
                        <a href="https://vrchat.com/home/world/{{ $world->id }}" target="_blank"
                            rel="noopener noreferrer">
                            <img class="rounded w-full m-2" src="{{ $world->imageUrl }}" alt="{{ $world->name }}">
                        </a>
                    </div>

                    <a href="https://vrchat.com/home/world/{{ $world->id }}" target="_blank"
                        rel="noopener noreferrer"
                        class="inline-block py-2 px-16 items-center justify-center align-middle font-bold text-lg rounded-md border border-gray-200 bg-white hover:bg-gray-100 cursor-pointer active:bg-gray-300 focus:outline-none">
                        Open in VRChat
                    </a>
                </div>
                <div class="w-2/3 overflow-hidden m-2 ml-8">
                    <div class="font-bold text-2xl whitespace-break-spaces">Description</div>
                    <div class=''>{{ $world->description }}</div>
                    <div class="font-bold text-2xl">capacity</div>
                    <div class=''>{{ $world->capacity }}</div>
                    <div class="font-bold text-2xl">created_at</div>
                    <div class=''>{{ substr($world->created_at, 0, 10) }}</div>
                    <div class="font-bold text-2xl">updated_at</div>
                    <div class=''>{{ substr($world->updated_at, 0, 10) }}</div>

                    <div class="w-full rounded overflow-hidden m-2 ml-0">
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
                        @include('layouts.review-card')
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
