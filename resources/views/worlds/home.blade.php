<x-app-layout>

    <body>
        <header>
            <nav class="my-navbar">
                <a class="my-navbar-brand" href="/">VRChat Review</a>
            </nav>
        </header>
        <main>
            <div class="container">
                <div class="row">
                    <div class="column col-md-8">
                        <!-- ここにタスクが表示される -->
                    </div>{{ $status }}
                </div>
                <a href="/auth_2FA_first">メール送信</a>
                <form action="/auth_2FA_second" method="POST">
                    @csrf
                    <div class="code">
                        <h2>Code</h2>
                        <input type="number" name="post" placeholder="000000" />
                    </div>
                    <input type="submit" value="送信" />
                </form>

                <form action="/worlds/search" method="POST">
                    @csrf
                    <div class="search">
                        <h2>Search</h2>
                        <input type="text" name="search[keyword]" placeholder="world name" value="" />
                        <div class="category">
                            <h2>Sort</h2>
                            <select name="search[sort]">
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
                    <input type="submit" value="検索" />
                </form>
            </div>
            <div>
                <h2>おすすめワールド</h2>
            </div>
            </div>
            </div>
        </main>
    </body>
</x-app-layout>
