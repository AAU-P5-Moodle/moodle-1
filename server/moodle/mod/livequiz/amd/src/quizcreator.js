
    function open_question_creation_modal() {
        // Corrected button ID
        let add_question_button = document.getElementById("id_buttonaddquestion");
        if (add_question_button){
            add_question_button.addEventListener('click', () => {create_question_modal()});
        }    
    }

    function create_question_modal() {
        let modal_div = document.createElement("div"); // Sådan laver man en div.
        modal_div.className = "Modal_div"; // Styles for this modal div to be handled in styles.css

        let page = document.getElementById("page-mod-livequiz-quizcreator");

        let question_input = document.createElement('textarea');
        question_input.placeholder = "Enter question";
        question_input.className = "question_input";

        modal_div.appendChild(question_input);

        modal_div.appendChild(create_file_picker());
        modal_div.appendChild(create_timer_element());

        let all_answers_for_question_div = document.createElement("div");
        all_answers_for_question_div.className = "all_answers_for_question_div";

        modal_div.appendChild(create_answer_button(all_answers_for_question_div));
        modal_div.appendChild(all_answers_for_question_div);

        modal_div.appendChild(save_question(page, question_input, modal_div, all_answers_for_question_div));
        modal_div.appendChild(create_discard_button());

        page.appendChild(modal_div);
    }

    function create_discard_button() {
        let discard_question_button = create_element("discard_button", "div", "discard_question_button", "Discard");


        discard_question_button.addEventListener('click', () => {
            let toast_promise_deletion_div = create_element("toast_promise_deletion_div", 'div',
                "toast_promise_deletion_div", "Are you sure you want to delete this question?");

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

        const image = document.createElement("img");

        file_picker_input.addEventListener('change', () => {
            const file = file_picker_input.files[0];

            image.src = URL.createObjectURL(file);


        });

        let file_container = document.createElement("div");
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

    function save_question(page, question_input, modal_div, answers_div) {
        let save_question_button = create_element("save_question_button",
            'button', "save_button", "Save question");

        save_question_button.addEventListener('click', () => {
            let question_for_main_page = create_element("question_for_main_page",
                'button', 'question_for_main_page', question_input.value);

            let answers_count = answers_div.children.length;
            let answers_is_filled = true;
            for (let i = 0; i < answers_count; i++) {
                if(answers_div.children[i].querySelector(".answer_input").value.trim() === "") {
                    answers_is_filled = false;
                    break;
                }
            }
            if (question_input.value.trim() === "" || answers_count < 2 || !answers_is_filled) {
                console.log("Could not save if no question is added or not all answers are filled.")
            } else {
                page.appendChild(question_for_main_page);
                modal_div.remove();
            }
        })

        return save_question_button
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
    });
