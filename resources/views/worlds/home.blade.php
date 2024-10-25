<x-app-layout>

    <body>
        <main>
            {{-- <div class="bg-orange-100">
                <a class="my-navbar-brand" href="/">VRChat Review</a>
            </div> --}}
            <div class="container">
                <div class="row">
                    <div class="column col-md-8">
                        <!-- ここにタスクが表示される -->
                    </div>{{ $status }}
                </div>
                <a href="/auth_2FA">二段階認証</a>
                {{-- <a href="/auth_2FA_first">メール送信</a>
                <form action="/auth_2FA_second" method="POST">
                    @csrf
                    <div class="code">
                        <h2>Code</h2>
                        <input type="number" name="post" placeholder="000000" />
                    </div>
                    <input type="submit" value="送信" />
                </form> --}}


            </div>
            <div>
                <h2>おすすめワールド</h2>
            </div>
            </div>
            </div>
        </main>
    </body>
</x-app-layout>
