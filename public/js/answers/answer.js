
// Google FormのIFrameのDOM要素を返す
function getIFrame(formUrl) {
    const src = formUrl + '?'
    const frame = document.createElement('iframe');
    frame.setAttribute('src', src);
    frame.setAttribute('width', '640');
    frame.setAttribute('height', '910');
    frame.setAttribute('frameborder', '0');
    frame.innerHTML = "読み込んでいます…";
    return frame;
}

if (document.querySelector('#form_container')) {
    const formContainer = document.querySelector('#form_container');
    const formUrl = formContainer.getAttribute("data-url");
    
    const frame = getIFrame(formUrl);
    formContainer.appendChild(frame);
}