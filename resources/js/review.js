    //いいねボタンのhtml要素を取得します。
    const likeBtns = document.querySelectorAll('.review-btn');
    //いいねボタンをクリックした際の処理を記述します。 
    likeBtns.forEach(likeBtn => {
        likeBtn.addEventListener('click', async (e) => {
            //クリックされた要素を取得しています。
            const clickedEl = e.target
            //クリックされた要素にlikedというクラスがあれば削除し、なければ付与します。これにより星の色の切り替えができます。      
            clickedEl.classList.toggle('text-green-500')
        })
    });
