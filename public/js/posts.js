
// 投稿された発言を非同期で取得し、表示する
function getAllPosts(){
    fetch(location.pathname+'/show_all')
        .then(response => {
            return response.json();
        })
        .then(res => {
            const posts_result = document.querySelector('#posts');
            console.log(res);
            res.forEach(post => {
                let post_result = `
                    <div class="post p-4 max-w-48 mb-4 rounded-lg shadow-md ${post['is_logged_user'] ? 'self-end' : 'self-start'}">
                    <h5 class="mb-2 text-lg font-bold text-gray-900">${post['user_name']}</h5>
                    <p class="text-gray-700">${post['body']}</p>
                    </div>`.trim();
                posts_result.insertAdjacentHTML('beforeend', post_result);
            })
        })
        .catch(error => {
            console.log(error);
        })
}

getAllPosts();