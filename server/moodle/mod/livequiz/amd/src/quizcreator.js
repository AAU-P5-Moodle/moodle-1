let savedQuestions = [];

function open_question_creation_modal() {
    let add_question_button = document.getElementById("id_buttonaddquestion");
    if (add_question_button){
        add_question_button.addEventListener('click', () => {create_question_modal()});
    }    
}

function create_question_modal() {
    let modal_div = document.createElement("div");
    modal_div.className = "Modal_div"; 

    let page = document.getElementById("page-mod-livequiz-quizcreator");

    let question_input = document.createElement('textarea');
    question_input.placeholder = "Enter question";
    question_input.className = "question_input";

    modal_div.appendChild(question_input);
    
    let file_picker = create_file_picker();
    modal_div.appendChild(file_picker);
    modal_div.appendChild(create_timer_element());

    let all_answers_for_question_div = document.createElement("div");
    all_answers_for_question_div.className = "all_answers_for_question_div";

    modal_div.appendChild(create_answer_button(all_answers_for_question_div));
    modal_div.appendChild(all_answers_for_question_div);

    modal_div.appendChild(save_question(page, question_input, modal_div, all_answers_for_question_div, file_picker));
    modal_div.appendChild(create_discard_button());

    page.appendChild(modal_div);
}

function create_discard_button() {
    let discard_question_button = create_element("discard_button", "div", "discard_question_button", "Discard");

    discard_question_button.addEventListener('click', () => {
        let toast_promise_deletion_div = create_element("toast_promise_deletion_div", 'div', "toast_promise_deletion_div", "Are you sure you want to delete this question?");
        let cancel_question_deletion_button = create_element("cancel_question_deletion_button", 'button', "cancel_question_deletion_button", "Cancel delete");
        let continue_question_deletion_button = create_element("continue_question_deletion_button", 'button', "continue_question_deletion_button", "Delete");

        toast_promise_deletion_div.appendChild(cancel_question_deletion_button);
        toast_promise_deletion_div.appendChild(continue_question_deletion_button);

        let modal_div = document.querySelector('.Modal_div');
        modal_div.appendChild(toast_promise_deletion_div);

        continue_question_deletion_button.addEventListener('click', () => {
            modal_div.remove();
        });

        cancel_question_deletion_button.addEventListener('click', () => {
            toast_promise_deletion_div.remove();
        });
    });

    return discard_question_button;
}

function create_file_picker() {
    let file_picker_input = create_element("file_input", "input", "file_picker_input", "");
    file_picker_input.type = 'file';
    file_picker_input.accept = ['image/*', 'video/*'];
    file_picker_input.className = 'file_upload_input';

    const image = document.createElement("img");

    file_picker_input.addEventListener('change', () => {
        const file = file_picker_input.files[0];
        image.src = URL.createObjectURL(file);
        image.style.maxWidth = "300px";
    });

    let file_container = document.createElement("div");
    file_container.className = 'file_upload_container';
    file_container.appendChild(file_picker_input);
    file_container.appendChild(image);

    return file_container;
}

function create_element(element_name, type, class_name, content) {
    element_name = document.createElement(type);
    element_name.className = class_name;
    element_name.textContent = content;
    return element_name;
}

function create_timer_element() {
    let timer_div = create_element("timer_div", "div", "time_limit_div", "Add time limit: ");

    let promise_timer_checkbox = create_element("timer_checkbox", "input", "promise_timer_checkbox", "");
    promise_timer_checkbox.setAttribute("type", "checkbox");

    let set_timer_input = create_element("timer_input", "input", "set_timer_input", "");
    set_timer_input.type = 'number';
    set_timer_input.placeholder = 0;
    set_timer_input.setAttribute('disabled', 'true');
    set_timer_input.className = 'timer_input';

    timer_div.appendChild(promise_timer_checkbox);
    timer_div.appendChild(set_timer_input);

    promise_timer_checkbox.addEventListener('change', () => {
        if (promise_timer_checkbox.checked) {
            set_timer_input.removeAttribute('disabled');
        } else {
            set_timer_input.setAttribute('disabled', 'true');
            set_timer_input.value = 0;
        }
    });

    return timer_div;
}

function save_question(page, question_input, modal_div, answers_div, file_picker) {
    let save_question_button = create_element("save_question_button", 'button', "save_button", "Save question");

    save_question_button.addEventListener('click', () => {
        let question_for_main_page = create_element("question_for_main_page", 'button', 'question_for_main_page', question_input.value);

        let answers = [];
        for (let i = 0; i < answers_div.children.length; i++) {
            answers.push(answers_div.children[i].querySelector(".answer_input").value.trim());
        }

        let file_input = file_picker.querySelector('input[type="file"]');
        let file = file_input.files[0];
        let savedQuestion = {
            question: question_input.value,
            answers: answers,
            file: file ? file.name : null
        };
        savedQuestions.push(savedQuestion);

        page.appendChild(question_for_main_page);
        modal_div.remove();

        setTimeout(() => {
            question_for_main_page.addEventListener('click', () => {
                open_saved_question_modal(savedQuestion); }); }, 0);
    });

    return save_question_button;
}

function open_saved_question_modal(savedQuestion) {
    let modal_div = document.createElement("div");
    modal_div.className = "Modal_div";

    let question_input = document.createElement('textarea');
    question_input.placeholder = "Enter question";
    question_input.className = "question_input";
    question_input.value = savedQuestion.question;

    modal_div.appendChild(question_input);

    let file_picker = create_file_picker();
    if (savedQuestion.file) {
        const image = file_picker.querySelector('img');
        image.src = URL.createObjectURL(savedQuestion.file);
        image.style.maxWidth = "300px";
    }
    modal_div.appendChild(file_picker);

    let all_answers_for_question_div = document.createElement("div");
    all_answers_for_question_div.className = "all_answers_for_question_div";

    savedQuestion.answers.forEach(answer => {
        let answer_container = document.createElement('div');
        answer_container.className = "container_for_new_answer";

        let answer_input = document.createElement('input');
        answer_input.className = "answer_input";
        answer_input.value = answer;

        answer_container.appendChild(answer_input);
        all_answers_for_question_div.appendChild(answer_container);
    });

    modal_div.appendChild(create_answer_button(all_answers_for_question_div));
    modal_div.appendChild(all_answers_for_question_div);
    
    modal_div.appendChild(save_question(document.getElementById("page-mod-livequiz-quizcreator"), question_input, modal_div, all_answers_for_question_div, file_picker));
    modal_div.appendChild(create_discard_button());

    let page = document.getElementById("page-mod-livequiz-quizcreator");
    page.appendChild(modal_div);
}

function create_answer_button(parent_element) {
    let add_new_answer_to_question = create_element("add_answer_button", 'button', 'add_new_answer_to_question', 'Add Answer');
    let answer_count = 0;

    add_new_answer_to_question.addEventListener('click', () => {
        if (answer_count < 8) {
            let answer_container = document.createElement('div');
            answer_container.className = "container_for_new_answer";

            let answer_input = document.createElement('input');
            answer_input.className = "answer_input";
            answer_input.placeholder = "Enter answer";
            answer_input.setAttribute("required", true);

            let answer_checkbox = document.createElement('input');
            answer_checkbox.setAttribute("type", "checkbox");
            answer_checkbox.className = 'answer_checkbox';

            let delete_answer_button = create_element("delete_answer_button", "button", "delete_answer_button", "X");

            answer_container.appendChild(answer_input);
            answer_container.appendChild(delete_answer_button);
            answer_container.appendChild(answer_checkbox);

            parent_element.appendChild(answer_container);
            answer_count++;

            delete_answer_button.addEventListener('click', () => {
                answer_container.remove();
                answer_count--;
            });
        }
    });
    return add_new_answer_to_question;
}


    document.addEventListener('DOMContentLoaded', ()=>{
        console.log("quizcreator JS loaded");

        open_question_creation_modal();

        const imageUploadInput = document.getElementById('imageUpload');
        const imagePreview = document.getElementById('imagePreview');
    
    if (imageUploadInput) {
        imageUploadInput.addEventListener('change', () => {
            const file = imageUploadInput.files[0];
            if (file) {
                imagePreview.src = URL.createObjectURL(file);
                imagePreview.style.display = 'block';
            }
        });
    }
});
