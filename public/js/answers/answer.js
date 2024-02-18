
// Google FormのIFrameのDOM要素を返す
function getIFrame(formId) {
    const src = 'https://docs.google.com/forms/d/e' 
        + formId + '/viewform?embedded=true';
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
    const formId = formContainer.getAttribute("data-id");
    
    const frame = getIFrame(formId);
    formContainer.appendChild(frame);
}