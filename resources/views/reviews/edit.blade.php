<x-app-layout>

    <body>
        <div class="flex justify-center">
            <div class=" m-4 w-1/3 rounded bg-white text-gray-700">
                <form action="/reviews/{{ $review->id }}" method="POST" class="m-8">
                    @csrf
                    @method('PUT')
                    <div class="">
                        <div class="font-bold text-xl">Title</div>
                        <input type="text" name="review[title]" value="{{ $review->title }}" class="w-full" />
                        <div class="" style="color:red">{{ $errors->first('review.title') }}</div>
                    </div>
                    <div class="">
                        <div class="font-bold text-xl">Rank</div>
                        <input type="number" name="review[rank]" value="{{ $review->rank }}" class="w-1/4" />
                    </div>
                    <div class="">
                        <div class="font-bold text-xl">Body</div>
                        <textarea name="review[body]" placeholder="きれいなワールドです。" class="w-full min-h-40">{{ $review->body }}</textarea>
                        <div class="" style="color:red">{{ $errors->first('review.body') }}</div>
                    </div>
                    <input type="hidden" name="review[user_id]" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="review[world_id]" value="{{ $world_id }}">
                    <div class="flex justify-center">
                        <input type="submit" value="投稿"
                            class="inline-block py-2 px-32 items-center justify-center align-middle font-bold text-lg rounded-md border border-gray-200 bg-white hover:bg-gray-100 cursor-pointer active:bg-gray-300 focus:outline-none" />
                    </div>
                </form>
            </div>
        </div>
    </body>
</x-app-layout>
