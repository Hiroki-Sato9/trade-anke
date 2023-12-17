

const forms = document.querySelectorAll(".show_form");
const btns = document.querySelectorAll(".show_btn");
const dialog = document.querySelector("#dialog");

function showDialog() {
}

btns.forEach((btn) => {
    // ボタンとフォームは同じ番号を末尾に持つ
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
                const result_table = document.querySelector("#dialog-content > table");
                init_table(result_table);
                // テーブルに質問-回答の要素を追加
                for (const item in res) {
                    const interview_html = `<tr>
                        <td>${res[item]["question"]}</td>
                        <td>${res[item]["answer"]}</td>
                        </tr>`.trim();
                    result_table.insertAdjacentHTML('beforeend', interview_html);
                }
            })
            .catch(error => {
                console.log(error);
            })
    });
});

function init_table(dialog) {
    const header_html = `
        <tr>
        <th>質問</th>
        <th>回答</th>
        </tr>`.trim();
    while (dialog.firstChild){
        dialog.removeChild(dialog.firstChild);
    }
    dialog.insertAdjacentHTML('beforeend', header_html);
}