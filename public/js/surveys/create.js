// 質問項目を増やすイベントの生成
class AddQuestion {
    constructor() {
        this.questions = document.querySelector('.questions');
        this.set_template();
        this.btn = document.querySelector('.add-question-btn');
        
        this.btn.addEventListener(('click'), () => {
            this.add();
        });
    }
    
    add() {
        this.get_template();
        let num = this.questions.children.length;
        console.log(this.question_template);
        this.new_question.querySelector('label').setAttribute('for', 'question' + num);
        this.new_question.querySelector('input').setAttribute('id', 'question' + num);
        
        this.questions.appendChild(this.new_question);
        this.get_template();
        // alert(num);
    }
    
    set_template() {
        this.question_template = this.questions.querySelector('.question').cloneNode(true);
    }
    
    get_template() {
        this.new_question = this.question_template.cloneNode(true);
    }
}



const ev = new AddQuestion();
