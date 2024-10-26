    //いいねボタンのhtml要素を取得します。
    const likeBtns = document.querySelectorAll('.favorite-btn');
    //いいねボタンをクリックした際の処理を記述します。 
    likeBtns.forEach(likeBtn => {
        likeBtn.addEventListener('click', async (e) => {
            //クリックされた要素を取得しています。
            const clickedEl = e.target
            //クリックされた要素にlikedというクラスがあれば削除し、なければ付与します。これにより星の色の切り替えができます。      
            clickedEl.classList.toggle('text-red-500')
            //記事のidを取得しています。
            
            const userId = e.target.dataset.userId
            const worldId = e.target.id

            //fetchメソッドを利用し、バックエンドと通信します。非同期処理のため、画面がかくついたり、真っ白になることはありません。
            const res = await fetch('/users/' + userId + '/favorite/' + worldId, {
                    //リクエストメソッドはPOST
                    method: 'POST',
                    headers: {
                        //Content-Typeでサーバーに送るデータの種類を伝える。今回はapplication/json
                        'Content-Type': 'application/json',
                        //csrfトークンを付与
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute(
                                'content')
                    },
                    // //バックエンドにいいねをした記事のidを送信します。
                    // body: JSON.stringify({
                    //     post_id: postId
                    // })
                })
                .then((res) => res.json())
                .then((data) => {
                    //記事のいいね数がバックエンドからlikesCountという変数に格納されて送信されるため、それを受け取りビューに反映します。
                    clickedEl.nextElementSibling.innerHTML = data.favoriteCount;
                })
                .catch(
                    //処理がなんらかの理由で失敗した場合に実施したい処理を記述します。
                    () => alert('処理が失敗しました。画面を再読み込みし、通信環境の良い場所で再度お試しください。'))

        })
    });
