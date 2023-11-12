
class AddQuestion {
    constructor() {
        this.questions = document.querySelector('.questions');
        this.get_template();
        this.btn = document.querySelector('.add-question-btn');
        
        this.btn.addEventListener(('click'), () => {
            this.add();
        });
    }
    
    add() {
        let num = this.questions.children.length;
        this.question_template.querySelector('label').setAttribute('for', 'question' + num);
        this.question_template.querySelector('input').setAttribute('id', 'question' + num);
        
        this.questions.appendChild(this.question_template);
        this.get_template();
    }
    
    get_template() {
        this.question_template = this.questions.children[0].cloneNode(true);
    }
}

const ev = new AddQuestion();

