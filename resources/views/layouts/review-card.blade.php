<div class="flex flex-col relative p-2 w-80 min-h-60 rounded overflow-hidden shadow-lg m-2 bg-white">
    <div class="flex m-2">
        <div class="font-bold text-base mx-0.5">{{ $review->username }}</div>

        <div class="absolute right-0 top-0 m-2" x-data="{ open: false }">
            <!-- 三点リーダーのアイコン -->
            <button @click="open = !open" class="p-2 rounded-full hover:bg-gray-200 focus:outline-none">
                <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 16a2 2 0 110 4 2 2 0 010-4zm0-6a2 2 0 110 4 2 2 0 010-4zm0-6a2 2 0 110 4 2 2 0 010-4z" />
                </svg>
            </button>

            <!-- メニューの内容 -->
            <div x-show="open" @click.away="open = false"
                class="absolute right-0 m-2 w-24 bg-white rounded-md shadow-lg z-20">
                <a href="/reviews/{{ $world->id }}/{{ $review->id }}/edit"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                <form action="/reviews/{{ $review->id }}" id="form_{{ $review->id }}"
                    method="post"class="block px-4 py-2 m-0 text-sm text-gray-700 hover:bg-gray-100">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="world_id" value="{{ $world->id }}">
                    <button type="button" onclick="deletePost({{ $review->id }})">Delete</button>
                </form>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Report</a>
            </div>
        </div>
    </div>
    <div class="font-bold underline text-xl m-2">{{ $review->title }}</div>
    @include('layouts.rank-star')
    <div class='m-2 whitespace-break-spaces'>{{ $review->body }}</div>
    @if ($review->image_url)
        <div class='flex-1 m-2 grid h-full place-content-end'>
            <img src="{{ $review->image_url }}" alt="画像が読み込めません。">
        </div>
    @endif
</div>
