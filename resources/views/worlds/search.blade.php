<x-app-layout>

    <body>
        <div class="font-bold">検索キーワード：{{ $search['keyword'] }}</div>

        <main>
            <div class="flex flex-wrap justify-center">
                @foreach ($worlds as $world)
                    @include('layouts.world-card')
                @endforeach
            </div>
            {{ $worlds->appends([
                    'worlds' => request()->query('worlds'),
                    'search' => request()->query('search'),
                    'sortByReview' => request()->query('sortByReview'),
                ])->links() }}
        </main>
    </body>
</x-app-layout>

<script>
    // プルダウンの初期値を変更
    document.getElementById("sort").value = "{{ $search['sort'] }}";
</script>
