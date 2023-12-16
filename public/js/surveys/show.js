

const forms = document.querySelectorAll(".show_form");
const btns = document.querySelectorAll(".show_btn");
const dialog = document.querySelector("#dialog");

function showDialog() {
}

btns.forEach((btn) => {
    const num = btn.id.match(/btn_([0-9]+)/)[1];
    btn.addEventListener('click', async (event) => {
        // フォームの情報を取り出し、インタビュー結果をダイアログに表示する
        const form = document.querySelector("#interview_" + num);
        const formData = new FormData(form);
        const options = {
            method: 'POST',
            body: formData,
        }
        const url = form.getAttribute('action');
        
        fetch(url, options)
            .then(response => {
                return response.json();
            })
            .then(res => {
                console.log(res);
            })
            .catch(error => {
                console.log(error);
            })
    });
});
