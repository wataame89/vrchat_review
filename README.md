![ヘッダー画像](/public/img/header.png)
# VRChat Review : 「口コミ特化型ワールド検索サイト」

## URL
**VRChat Review**  
https://vrchat-review-7928b36ce9a9.herokuapp.com/  
<br />

**テストアカウント**  
Mail : test_user0@mail  
PASS : test_pass0   

<br />

## 制作背景
私はコロナ禍から、オンライン上で人とコミュニケーションの取れるVRに熱中してきました。  
現在のVRサービスの中には、都会、自然、店舗、観光地など様々な場所(ワールド)が存在し、コンテンツの大部分を占めています。  
一方で、ワールドは10万件以上存在し、その中から質の高いワールドを見つけるのは容易ではありません。  
本サービスは、ユーザーのリアルな声に触れられる「口コミ特化型ワールド検索サイト」を提供し、VR上のワールド探索という課題を解決するために制作されました。

<br />

## デモ動画

https://github.com/user-attachments/assets/c101be3e-9e15-468f-aa3b-8614761a3abb

<br />

## 機能一覧
| トップ画面 |　ログイン画面 |
| ---- | ---- |
| ![Top画面](/public/img/home_all.png) | ![ログイン画面](/public/img/login_all.png) |
| 現在人気のワールドを表示しています。 | メールアドレスとパスワードでの認証機能を実装しました。 |

| ワールド検索画面 |　ワールド詳細画面 |
| ---- | ---- |
| ![ワールド検索画面](/public/img/search_all.png) | ![ワールド詳細画面](/public/img/world_all.png) |
| キーワードからワールドを検索し、複数の方法でソートする機能を実装しました。  | ワールドの詳細を表示する機能を実装しました。また、いいね、来訪済み、口コミの機能を実装しました。 |

| 口コミ投稿画面 |　ユーザーページ画面 |
| ---- | ---- |
| ![口コミ投稿画面](/public/img/review.png) | ![　ユーザーページ画面](/public/img/userpage.png) |
| 口コミ投稿機能を実装しました。 | 各ユーザーのユーザーページを表示する機能を実装しました。いいね、来訪済み、口コミの3点についてのワールド、口コミが表示されます。 |

<br />

## 使用技術

| Category          | Technology Stack                                     |
| ----------------- | --------------------------------------------------   |
| Frontend          | JavaScript, HTML, TailwindCSS                        |
| Backend           | PHP, Laravel                                         |
| Infrastructure    | Heroku                                               |
| Database          | MySQL                                                |
| Monitoring        | Sentry, UptimeRobot                                  |
| Design            | draw.io                                              |

<br />

## 重視した点
- ユーザーの導線の意識
    - 検索→いいね→ワールド訪問→訪問済み→口コミ
    - 普段使いのしやすさを考え、以上の流れを重視した。
- シンプルさ
    - サーチバーをどこからでもアクセス可能に。
    - 口コミ投稿をを他の画面に遷移せずに行えるように。

<br />

## 今後の展望
本プロダクトは、ワールド検索機能とSNS機能を合わせたサービスとして設計しています。  
現在は、主に検索機能と、SNS機能の前身として口コミ機能の開発を進めています。  
将来的には、ワールドの検索とSNSのマイクロブログ投稿により、循環的にユーザーからの口コミが集まるサービスの実現を目指しています。  

- 検索機能：検索機能、いいね、来訪済み、口コミ機能の実装。
- ブログ機能：ユーザー同士のフォロー機能の実装、口コミのマイクロブログ化。
