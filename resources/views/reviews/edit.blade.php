<x-app-layout>

    <body>
        <div class="flex justify-center">
            <div class=" m-4 w-1/3 min-w-96 rounded bg-white text-gray-700">
                <a href="/worlds/{{ $world->id }}">
                    <img class="w-full" src="{{ $world->imageUrl }}" alt="{{ $world->name }}">
                    <div class="font-bold text-2xl m-2 text-center">{{ $world->name }}</div>
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

                <form action="/reviews/{{ $review->id }}" method="POST" enctype="multipart/form-data" class="m-8">
                    @csrf
                    @method('PUT')
                    <div class="">
                        <div class="font-bold text-xl my-2">口コミ</div>
                        <div class="font-bold text-xl">タイトル</div>
                        <input type="text" name="review[title]" placeholder="タイトル" value="{{ $review->title }}"
                            class="w-full" />
                        <div class="" style="color:red">{{ $errors->first('review.title') }}</div>
                    </div>
                    <div class="">
                        <div class="font-bold text-xl my-2">評価</div>
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
                        <div class="" style="color:red">{{ $errors->first('review.rank') }}</div>
                    </div>

                    <div class="">
                        <div class="font-bold text-xl my-2">本文</div>
                        <textarea name="review[body]" placeholder="ワールドについて" class="w-full min-h-40">{{ $review->body }}</textarea>
                        <div class="" style="color:red">{{ $errors->first('review.body') }}</div>
                    </div>
                    <div class='m-2'>
                        <img src="{{ $review->image_url }}" alt="画像が読み込めません。">
                    </div>
                    <div class="">
                        <div class="font-bold text-xl my-2">添付画像</div>
                        <input type="file" name="image"class="inline-block mb-4 align-middle text-lg">
                    </div>
                    <input type="hidden" name="review[user_id]" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="review[world_id]" value="{{ $world->id }}">
                    <div class="flex justify-center">
                        <input type="submit" value="投稿"
                            class="inline-block py-2 px-32 m-4 items-center justify-center align-middle font-bold text-lg
                                rounded-md border-2 border-gray-300 bg-gray-50 
                                hover:bg-gray-200 active:bg-gray-300 cursor-pointer focus:outline-none" />
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
