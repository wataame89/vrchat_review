<x-app-layout>

    <body>
        <div class="text-center text-xl m-4">Mypage of {{ $user->name }}</div>

        <div class="text-center text-2xl font-bold m-4">Favorite World</div>
        <div class="text-center flex flex-wrap justify-center">
            @foreach ($favorite_worlds as $world)
                @include('layouts.world-card')
            @endforeach
        </div>

        <div class="text-center text-2xl font-bold m-4">Visited World</div>
        <div class="text-center flex flex-wrap justify-center">
            @foreach ($visited_worlds as $world)
                @include('layouts.world-card')
            @endforeach
        </div>

        <div class="text-center text-2xl font-bold m-4">Review</div>
        <div class="flex flex-wrap justify-center">
            @if ($reviews)
                @foreach ($reviews as $review)
                    @include('layouts.review-card')
                @endforeach
            @endif
        </div>
    </body>
</x-app-layout>
