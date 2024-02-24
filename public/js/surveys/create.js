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


const radio_buttons = document.querySelectorAll("input[type='radio'][name='question_type']");
const google_form = document.querySelector('.google-forms');
const default_form = document.querySelector('.default_form');
// ラジオボタンの選択によって、フォームにhiddenクラスをトグルする
for (const target of radio_buttons) {
    target.addEventListener('change', () => {
        google_form.classList.toggle('hidden');
        default_form.classList.toggle('hidden');
    });
}


const ev = new AddQuestion();
