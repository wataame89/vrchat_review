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
                    <a href="/auth_2FA_first">メール送信</a>
                    <form action="/auth_2FA_second" method="POST">
                        @csrf
                        <div class="code">
                            <h2>Code</h2>
                            <input type="number" name="post" placeholder="000000"/>
                        </div>
                        <input type="submit" value="保存"/>
                    </form>
                    <form action="/worlds/search" method="POST">
                        @csrf
                        <div class="search">
                            <h2>Search</h2>
                            <input type="text" name="post" placeholder="world name"/>
                        </div>
                        <input type="submit" value="保存"/>
                    </form>
                </div>
                <a href="/worlds">ワールド取得テスト</a>
                <div>
                    <h2>おすすめワールド</h2>
                </div>
            </div>
        </div>
    </main>
    </body>
</x-app-layout>