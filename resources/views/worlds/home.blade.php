<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
<header>
    <nav class="my-navbar">
        <a class="my-navbar-brand" href="/">Home</a>
    </nav>
</header>
<main>
    <div class="container">
        <div class="row">
            <div class="col col-md-4">
                <nav class="panel panel-default">
                    <div class="panel-heading">フォルダ</div>
                    <div class="panel-body">
                        <a href="#" class="btn btn-default btn-block">
                            フォルダを追加する
                        </a>
                    </div>
                    <div class="list-group">
                        <table class="table foler-table">
                            <tr>
                                <td>
                                </td>
                                <td><a href="#">編集</a></td>
                                <td><a href="#">削除</a></td>
                            </tr>
                        </table>
                    </div>
                </nav>
            </div>
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
            </div>
            <a href="/world">ワールド取得</a>
        </div>
    </div>
</main>
</body>
</html>