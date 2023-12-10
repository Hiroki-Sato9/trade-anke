
function getAllPosts(){
    fetch(location.pathname+'/show_all')
        .then(response => {
            return response.json();
        })
        .then(res => {
            const posts_result = document.querySelector('#posts');
            console.log(res);
            res.forEach(post => {
                let post_result = `<div>${post['body']}</div>`;
                posts_result.insertAdjacentHTML('beforeend', post_result);
            })
        })
        .catch(error => {
            console.log(error);
        })
}

getAllPosts();