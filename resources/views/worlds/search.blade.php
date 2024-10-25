<x-app-layout>

    <body>
        <div>検索キーワード：{{ $search['keyword'] }}</div>

        <main>
            <div class="text-center flex flex-wrap justify-center">
                @foreach ($worlds as $world)
                    @include('layouts.world_template')
                @endforeach
            </div>
            {{ $worlds->appends([
                    'worlds' => request()->query('worlds'),
                    'search' => request()->query('search'),
                    'sortByReview' => request()->query('sortByReview'),
                ])->links() }}
            <a href="/">return</a>
        </main>
    </body>
</x-app-layout>
<script>
    // プルダウンの初期値を変更
    document.getElementById("sort").value = "{{ $search['sort'] }}";
</script>
