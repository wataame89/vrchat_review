<x-app-layout>

    <body>
        <div class="text-xl">Mypage of {{ $user->name }}</div>

        <div class="text-center text-xl bold">Favorite World</div>
        <div class="text-center flex flex-wrap justify-center">
            @foreach ($favorite_worlds as $world)
                @include('layouts.world_template')
            @endforeach
        </div>

        <div class="text-center text-xl">Visited World</div>
        <div class="text-center flex flex-wrap justify-center">
            @foreach ($visited_worlds as $world)
                @include('layouts.world_template')
            @endforeach
        </div>
    </body>
</x-app-layout>
