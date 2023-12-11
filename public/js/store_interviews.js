
const posts = document.querySelectorAll(".post");

const question_form = document.querySelector("#question");
const answer_form = document.querySelector("#answer");

posts.forEach((post) => {
    post.addEventListener("click", () => {
        let post_body = post.querySelector("div").textContent;
        // postにrequest_userクラスを持つ要素があれば
        if (post.classList.contains("request_user")){
            console.log("request user");
            question_form.value = post_body;
        }else if(post.classList.contains("requested_user")){
            answer_form.value = post_body;
            console.log("requested user");
        }
    })
});

