//いいねボタンのhtml要素を取得します。
const likeBtns = document.querySelectorAll(".visited-btn");
//いいねボタンをクリックした際の処理を記述します。
likeBtns.forEach((likeBtn) => {
  likeBtn.addEventListener("click", async (e) => {
    //クリックされた要素を取得しています。
    const clickedEl = e.target;
    //クリックされた要素にlikedというクラスがあれば削除し、なければ付与します。これにより星の色の切り替えができます。
    clickedEl.classList.toggle("text-blue-500");
    //記事のidを取得しています。
    const isTurnedOn = clickedEl.classList.contains("text-blue-500");

    if (isTurnedOn) {
      const reviewButton = likeBtn
        .closest(".text-center")
        .querySelector(".fa-comment");
      const reviewButtonDiv = reviewButton.closest(".m-0");
      console.log(likeBtn.closest(".text-center").querySelector(".fa-comment"));
      if (!reviewButton.classList.contains("text-green-500")) {
        reviewButtonDiv.classList.add("animate-bounce");
      }
    }

    const userId = e.target.dataset.userId;
    const worldId = e.target.id;

    // if (isTurnedOn) {
    //   // document.getElementById("popup").classList.remove("hidden");
    //   const visitedWorldReviewForm = document
    //     .getElementById("review_form_" + worldId)
    //     .cloneNode(true);
    //   const popUpWindow = document.getElementById("popup");
    //   // console.log("review_form_" + worldId);
    //   // console.log(visitedWorldReviewForm);
    //   visitedWorldReviewForm.classList.remove("hidden");
    //   popUpWindow.classList.remove("hidden");
    //   popUpWindow.appendChild(visitedWorldReviewForm);
    // }

    //fetchメソッドを利用し、バックエンドと通信します。非同期処理のため、画面がかくついたり、真っ白になることはありません。
    const res = await fetch("/users/" + userId + "/visited/" + worldId, {
      //リクエストメソッドはPOST
      method: "POST",
      headers: {
        //Content-Typeでサーバーに送るデータの種類を伝える。今回はapplication/json
        "Content-Type": "application/json",
        //csrfトークンを付与
        "X-CSRF-TOKEN": document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content"),
      },
      // //バックエンドにいいねをした記事のidを送信します。
      // body: JSON.stringify({
      //     post_id: postId
      // })
    })
      .then((res) => res.json())
      .then((data) => {
        //記事のいいね数がバックエンドからlikesCountという変数に格納されて送信されるため、それを受け取りビューに反映します。
        clickedEl.nextElementSibling.innerHTML = data.visitedCount;
      })
      .catch(
        //処理がなんらかの理由で失敗した場合に実施したい処理を記述します。
        () =>
          alert(
            "処理が失敗しました。画面を再読み込みし、通信環境の良い場所で再度お試しください。"
          )
      );
  });
});
