
function getAllPosts(){
    fetch(location.pathname+'/show_all')
        .then(response => {
            return response.json();
        })
        .then(res => {
            const posts_result = document.querySelector('#posts');
            console.log(res);
            res.forEach(post => {
                let post_result = `<div class="post w-48 mb-4 ${post['is_logged_user'] ? 'self-end' : 'self-start'}">
                    <span>${post['user_name']}</span>
                    <div>${post['body']}</div>
                    </div>`.trim();
                posts_result.insertAdjacentHTML('beforeend', post_result);
            })
        })
        .catch(error => {
            console.log(error);
        })
}

getAllPosts();