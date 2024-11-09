<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Cache;

class VRChatController extends Controller
{
    public function test()
    {
        dump(Cache::get('authcookieJar'));
        return view('vrchat/2fa');
    }

    public function auth_2FA()
    {
        echo $response1 = $this->auth_2FA_first();
        sleep(5);
        echo $response2 = $this->auth_2FA_second(new Request);
        // return view('vrchat/2fa');
        return redirect("/");
    }

    public function auth_2FA_first()
    {
        // クライアントインスタンス生成
        $client = new Client();

        //クッキーインスタンス作成
        $cookieJar = new CookieJar();

        // GET通信するURL
        $url = 'https://api.vrchat.cloud/api/1/auth/user';

        // リクエスト送信と返却データの取得
        // User-Agent設定が適切でない場合、403エラーが発生する
        $response = $client->request('GET', $url, [
            'headers' => [
                "User-Agent" => config('services.vrchat.username')
            ],
            'data' => [
                'apiKey' => config('services.vrchat.apikey')
            ],
            'cookies' => $cookieJar,
            'auth' => [
                config('services.vrchat.username'),
                config('services.vrchat.password')
            ]
        ]);
        // echo $response->getBody();

        // キャッシュを保存
        Cache::forever('authcookieJar', $cookieJar);

        // return view('vrchat/2fa');
        return $response->getBody();
    }

    public function auth_2FA_second($passcode)
    {
        // $authcode = $request['post'];
        echo $authcode = $this->getOneTimeCode();
        // echo $authcode = $passcode;
        $cookieJar = Cache::get('authcookieJar');

        $url = 'https://api.vrchat.cloud/api/1/auth/twofactorauth/emailotp/verify';

        $client = new Client();

        $response = $client->request('POST', $url, [
            'headers' => [
                'User-Agent' => config('services.vrchat.username'),
                'Content-Type' => 'application/json',
            ],
            'cookies' => $cookieJar,
            'json' => [
                'code' => $authcode
            ]
        ]);
        // echo $response->getBody();

        // dump($response);
        // dump($response->getBody());
        // dump($cookieJar);

        Cache::forever('authcookieJar', $cookieJar);

        // return view('vrchat/2fa');
        return $response->getBody();
    }


    public function getOneTimeCode()
    {
        $client = $this->getClient();
        $service = new \Google\Service\Gmail($client);

        $user = 'me';
        $messages = $service->users_messages->listUsersMessages($user);

        foreach ($messages->getMessages() as $message) {
            $message_id = $message->getID();
            $message_contents = $service->users_messages->get($user, $message_id);

            // ヘッダーの取得
            $headers = $message_contents['payload']['headers']; // ヘッダーオブジェクトの配列
            $subject_key = array_search('Subject', array_column($headers, 'name')); // ヘッダーオブジェクトの配列から件名オブジェクトの連番キーを取得
            $subject = $headers[$subject_key]->value; // 件名のオブジェクトからvalueプロパティの値を取得

            // dump($subject);
            if (str_contains($subject, 'Your One-Time Code is ', )) {
                $code = str_replace('Your One-Time Code is ', '', $subject);
                // dump($code);
                return $code;
            }
            // dump($subject);
        }
        return null;
    }

    private function getClient()
    {
        $oauth_credential = Storage::path('gmailApi/credentials.json'); // oauthクライアントを作成してDLしたjsonのパス
        $oauth_access_token = Storage::path('gmailApi/access_token.json'); // oauth認証後に取得するアクセストークンのパス

        $client = new \Google\Client();
        $client->setApplicationName('Gmail API PHP Quickstart');
        $client->setScopes(\Google\Service\Gmail::GMAIL_READONLY); // スコープをメール一覧取得用に変更
        $client->setAuthConfig($oauth_credential);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // アクセストークンの利用
        if (file_exists($oauth_access_token)) {
            $accessToken = json_decode(file_get_contents($oauth_access_token), true);
            $client->setAccessToken($accessToken);
        }

        // アクセストークンが有効期限切れの場合は、リフレッシュトークンを利用して更新する
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($oauth_access_token, json_encode($client->getAccessToken()));
        }

        return $client;
    }
}
