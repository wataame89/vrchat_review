<x-app-layout>

    <body>
        <div>検索キーワード：{{ $search['keyword'] }}</div>
        <form action="/worlds/search" method="POST">
            @csrf
            <div class="search">
                <div class="category">
                    <input type="hidden" name="search[keyword]" value="{{ $search['keyword'] }}" />
                    Sort
                    <select id="sort" name="search[sort]">
                        <option value="popularity">popularity</option>
                        {{-- <option value="_created_at">_created_at</option>
                        <option value="_updated_at">_updated_at</option> --}}
                        <option value="favorites">favorites</option>
                        <option value="heat">heat</option>
                        <option value="trust">trust</option>
                    </select>
                    <label for="switch">
                        <input type="checkbox" id="switch" name="sortByReview" value="on" />
                        口コミのある投稿を優先
                    </label>
                </div>
            </div>
            <input type="submit" value="更新" />
        </form>

        <main>
            @foreach ($worlds as $world)
                @include('layouts.world_template')
            @endforeach
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
