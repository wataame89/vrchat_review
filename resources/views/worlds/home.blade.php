<x-app-layout>
    <title>Code Kitchen（コードキッチン）</title>

    <body>
        <main>
            {{-- <div class="bg-orange-100">
                <a class="my-navbar-brand" href="/">VRChat Review</a>
            </div> --}}
            {{-- <div class="">
                <div class="">
                    <div class="">
                    </div>{{ $status }}
                </div>
                <a href="/auth_2FA">二段階認証</a>
            </div> --}}
            {{-- <a href="/auth_2FA_first">メール送信</a>
                <form action="/auth_2FA_second" method="POST">
                    @csrf
                    <div class="code">
                        <h2>Code</h2>
                        <input type="number" name="post" placeholder="000000" />
                    </div>
                    <input type="submit" value="送信" />
                </form> --}}
            <div class="flex justify-center">
                <div class="text-center text-2xl font-bold w-1/2 m-12 px-8 py-6 shadow-lg rounded bg-gray-100">
                    <i class="fa-solid fa-flag"></i>
                    VRChat Reviewは口コミ特化型ワールド検索サイトです!
                </div>
            </div>
            <div class="text-center text-2xl font-bold m-4">本日のおすすめワールド</div>
            <div class="flex flex-wrap justify-center">
                @foreach ($worlds as $world)
                    @include('layouts.world-card')
                @endforeach
            </div>
        </main>
    </body>
</x-app-layout>
