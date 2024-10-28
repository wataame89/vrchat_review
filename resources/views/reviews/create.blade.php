<x-app-layout>

    <body>
        <div class="flex justify-center">
            <div class=" m-4 w-1/3 rounded bg-white text-gray-700">
                <a href="/worlds/{{ $world->id }}">
                    <img class="w-full" src="{{ $world->imageUrl }}" alt="{{ $world->name }}">
                    <div class="font-bold text-2xl m-2 text-center">{{ $world->name }}</div>
                    {{-- <div class="text-gray-700 text-sm">
                        author : {{ $world->authorName }}
                    </div> --}}
                </a>

                <div class="px-6 pt-4 pb-2 text-center ">
                    @foreach ($world->tags as $tag)
                        @if (Str::contains($tag, 'author_tag_'))
                            <span
                                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                                {{ Str::after($tag, 'author_tag_') }}
                            </span>
                        @endif
                    @endforeach
                </div>

                <form action="/reviews" method="POST" class="m-8">
                    @csrf
                    <div class="">
                        <div class="font-bold text-xl my-2">Review</div>
                        <div class="font-bold text-xl">Title</div>
                        <input type="text" name="review[title]" placeholder="タイトル" value="{{ old('review.title') }}"
                            class="w-full" />
                        <div class="" style="color:red">{{ $errors->first('review.title') }}</div>
                    </div>
                    <div class="">
                        <div class="font-bold text-xl">Rank</div>
                        {{-- <input type="number" name="review[rank]" placeholder="3" class="w-1/4" /> --}}
                        <div class="my-2">
                            <label>
                                <input type="radio" name="review[rank]" value="1" class="hidden">
                                <i class="fa-solid fa-star text-2xl w-8 h-8 cursor-pointer fill-current text-gray-400"
                                    data-rating="1">
                                </i>
                            </label>
                            <label>
                                <input type="radio" name="review[rank]" value="2" class="hidden">
                                <i class="fa-solid fa-star text-2xl w-8 h-8 cursor-pointer fill-current text-gray-400"
                                    data-rating="2">
                                </i>
                            </label>
                            <label>
                                <input type="radio" name="review[rank]" value="3" class="hidden">
                                <i class="fa-solid fa-star text-2xl w-8 h-8 cursor-pointer fill-current text-gray-400"
                                    data-rating="3">
                                </i>
                            </label>
                            <label>
                                <input type="radio" name="review[rank]" value="4" class="hidden">
                                <i class="fa-solid fa-star text-2xl w-8 h-8 cursor-pointer fill-current text-gray-400"
                                    data-rating="4">
                                </i>
                            </label>
                            <label>
                                <input type="radio" name="review[rank]" value="5" class="hidden">
                                <i class="fa-solid fa-star text-2xl w-8 h-8 cursor-pointer fill-current text-gray-400"
                                    data-rating="5">
                                </i>
                            </label>
                        </div>
                    </div>

                    <div class="">
                        <div class="font-bold text-xl">Body</div>
                        <textarea name="review[body]" placeholder="きれいなワールドです。" class="w-full min-h-40">{{ old('review.body') }}</textarea>
                        <div class="" style="color:red">{{ $errors->first('review.body') }}</div>
                    </div>
                    <input type="hidden" name="review[user_id]" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="review[world_id]" value="{{ $world->id }}">
                    <div class="flex justify-center">
                        <input type="submit" value="投稿"
                            class="inline-block py-2 px-32 items-center justify-center align-middle font-bold text-lg rounded-md border border-gray-200 bg-white hover:bg-gray-100 cursor-pointer active:bg-gray-300 focus:outline-none" />
                    </div>
                </form>
            </div>
        </div>
    </body>
</x-app-layout>

<script>
    document.querySelectorAll('input[name="review[rank]"]').forEach((radio) => {
        radio.addEventListener('change', (event) => {
            const selectedRating = event.target.value;
            document.querySelectorAll('i[data-rating]').forEach((star) => {
                star.classList.toggle('text-yellow-500', star.getAttribute('data-rating') <=
                    selectedRating);
                star.classList.toggle('text-gray-400', star.getAttribute('data-rating') >
                    selectedRating);
            });
        });
    });
</script>
