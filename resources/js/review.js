//いいねボタンのhtml要素を取得します。
const likeBtns = document.querySelectorAll(".review-btn");
//いいねボタンをクリックした際の処理を記述します。
likeBtns.forEach((likeBtn) => {
  likeBtn.addEventListener("click", async (e) => {
    //クリックされた要素を取得しています。
    const clickedEl = e.target;
    //クリックされた要素にlikedというクラスがあれば削除し、なければ付与します。これにより星の色の切り替えができます。
    // clickedEl.classList.toggle("text-green-500");
    // let isTurnedOn = clickedEl.classList.contains("text-green-500");

    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });

    const userId = e.target.dataset.userId;
    const worldId = e.target.id;

    // if (isTurnedOn) {
    // document.getElementById("popup").classList.remove("hidden");
    const visitedWorldReviewForm = document
      .getElementById("review_form_" + worldId)
      .cloneNode(true);
    const popUpWindow = document.getElementById("popup");
    // console.log("review_form_" + worldId);
    // console.log(visitedWorldReviewForm);
    visitedWorldReviewForm.classList.remove("hidden");
    popUpWindow.classList.remove("hidden");
    popUpWindow.appendChild(visitedWorldReviewForm);
    // }

    document.querySelectorAll('input[name="review[rank]"]').forEach((radio) => {
      console.log(radio);

      radio.addEventListener("change", (event) => {
        console.log(event);
        const selectedRating = event.target.value;
        document.querySelectorAll("i[data-rating]").forEach((star) => {
          star.classList.toggle(
            "text-yellow-500",
            star.getAttribute("data-rating") <= selectedRating
          );
          star.classList.toggle(
            "text-gray-400",
            star.getAttribute("data-rating") > selectedRating
          );
        });
      });
    });
  });
});
