let savedQuestions = [];
let isEditing = false;
let editingIndex = null;
 
    function open_question_creation_modal() {
        let add_question_button = document.getElementById("id_buttonaddquestion");
        if (add_question_button){
            add_question_button.addEventListener('click', () => {create_question_modal()});
        }    
    }
 
 
    function create_question_modal() {
 
        if (document.querySelector('.Modal_div')) {
            return; 
        }
 
        let modal_div = document.createElement("div"); 
        modal_div.className = "Modal_div";
 
        let page = document.getElementById("page-mod-livequiz-quizcreator");
 
        let question_input = document.createElement('textarea');
        question_input.placeholder = "Enter question";
        question_input.className = "question_input_large";
 
        modal_div.appendChild(question_input);
 
        let file_picker = create_file_picker();
        modal_div.appendChild(create_file_picker());
        modal_div.appendChild(create_timer_element());
 
        let all_answers_for_question_div = document.createElement("div");
        all_answers_for_question_div.className = "all_answers_for_question_div";
 
        modal_div.appendChild(create_answer_button(all_answers_for_question_div));
        modal_div.appendChild(all_answers_for_question_div);
        let saveButton = save_question(page, question_input, modal_div, all_answers_for_question_div, file_picker)
        modal_div.appendChild(saveButton);
        modal_div.appendChild(create_discard_button());
 
        page.appendChild(modal_div);
    }
    
    function create_discard_button() {
        let discard_question_button = create_element("discard_button", "div", "discard_question_button", "Discard");
    
        discard_question_button.addEventListener('click', () => {
            let toast_promise_deletion_div = create_element("toast_promise_deletion_div", 'div', "toast_promise_deletion_div", "Are you sure you want to discard changes?");
            let cancel_question_deletion_button = create_element("cancel_question_deletion_button", 'button', "cancel_question_deletion_button", "No");
            let continue_question_deletion_button = create_element("continue_question_deletion_button", 'button', "continue_question_deletion_button", "Yes");
    
            toast_promise_deletion_div.appendChild(cancel_question_deletion_button);
            toast_promise_deletion_div.appendChild(continue_question_deletion_button);
    
            let modal_div = document.querySelector('.Modal_div');
            modal_div.appendChild(toast_promise_deletion_div);
    
            continue_question_deletion_button.addEventListener('click', () => {
                isEditing = false;
                editingIndex = null
                modal_div.remove();
            });
    
            cancel_question_deletion_button.addEventListener('click', () => {
                toast_promise_deletion_div.remove();
            });
        });
    
        return discard_question_button;
    }

    function create_delete_button(index) {
        let delete_question_button = create_element("delete_button", "button", "delete_question_button", "Delete Question");
    
        delete_question_button.addEventListener('click', () => {
            let toast_promise_deletion_div = create_element("toast_promise_deletion_div", 'div', "toast_promise_deletion_div", "Are you sure you want to delete this question?");
            let cancel_question_deletion_button = create_element("cancel_question_deletion_button", 'button', "cancel_question_deletion_button", "No");
            let continue_question_deletion_button = create_element("continue_question_deletion_button", 'button', "continue_question_deletion_button", "Yes");

            toast_promise_deletion_div.appendChild(cancel_question_deletion_button);
            toast_promise_deletion_div.appendChild(continue_question_deletion_button);

            let modal_div = document.querySelector('.Modal_div');
            modal_div.appendChild(toast_promise_deletion_div);

            continue_question_deletion_button.addEventListener('click', () => {
                savedQuestions.splice(index,1);
                
                let saved_questions_list = document.getElementById("saved_questions_list");
                let question_list_item = saved_questions_list.children[index]
                if (question_list_item){
                    saved_questions_list.removeChild(question_list_item);
                }
                for (let i = index; i < saved_questions_list.children.length; i++) {
                    saved_questions_list.children[i].dataset.index = i;
                }
                isEditing = false;
                editingIndex = null
                modal_div.remove();
            });

            cancel_question_deletion_button.addEventListener('click', () => {
                toast_promise_deletion_div.remove();
            });
        });
    
        return delete_question_button;
    }

    function create_cancel_button() {
        let cancel_button = create_element("cancel_button", "button", "cancel_button", "Cancel");
    
        
        cancel_button.addEventListener('click', () => {
            console.log('Cancel button clicked!');
            // Add cancel functionality here
        });
    
        document.body.appendChild(cancel_button);  // Append it to the body for fixed positioning
    }
 
    function create_file_picker() {
        let file_picker_input = create_element("file_input", "input", "file_picker_input", "");
        file_picker_input.type = 'file';
        file_picker_input.accept = ['image/*', 'video/*'];
        file_picker_input.id = "file_input"; 
 
        const image = document.createElement('img');
 
        let file_label = document.createElement('label');
        file_label.htmlFor = "file_input";  
        file_label.className = "file_upload_section";
        file_label.textContent = "+ Add video or image";  
 
 
        let preview = document.createElement("img");
        preview.style.display = "none";
        preview.style.maxWidth = "50%";
        preview.style.maxHeight = "200px";
        preview.style.marginTop = "10px";
        preview.className = "preview_image";
 
        file_picker_input.addEventListener('change', () => {
            const file = file_picker_input.files[0];
            image.src = URL.createObjectURL(file);
            image.style.display = 'block';
        });
 
        let file_container = document.createElement("div");
        file_container.className = "file_upload_section"; 
        file_container.appendChild(file_label);  
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
        let timer_div = document.createElement("div");
        timer_div.className = "time_limit_container";
 
 
        let timer_label = document.createElement("label");
        timer_label.textContent = "Add time limit: ";
        timer_label.className = "time_limit_label"; 
 
        let promise_timer_checkbox = document.createElement("input");
        promise_timer_checkbox.setAttribute("type", "checkbox");
        promise_timer_checkbox.className = "time_limit_checkbox"; 
 
        let set_timer_input = document.createElement("input");
        set_timer_input.type = 'number';
        set_timer_input.placeholder = "0 sec";
        set_timer_input.className = "set_timer_input"; 
        set_timer_input.setAttribute('disabled', 'true'); 
        set_timer_input.style.textAlign = "center"; 
 
 
        promise_timer_checkbox.addEventListener('change', () => {
            if (promise_timer_checkbox.checked) {
                set_timer_input.removeAttribute('disabled'); 
            } else {
                set_timer_input.setAttribute('disabled', 'true'); 
                set_timer_input.value = "";
            }
        });
 
 
        let timer_input_container = document.createElement("div");
        timer_input_container.className = "timer_input_container"; 
 
 
        timer_input_container.appendChild(promise_timer_checkbox);
        timer_input_container.appendChild(set_timer_input);
 
 
        timer_div.appendChild(timer_label);
        timer_div.appendChild(timer_input_container);  
 
        return timer_div;
    }
 
    function save_question(page, question_input, modal_div, answers_div, file_picker) {
        let save_question_button = create_element("save_question_button", 'button', "save_button", "Save question");
        save_question_button.addEventListener('click', () => {
            let questionText = question_input.value.trim();
            if (!questionText) {
                alert("Please enter a question.");
                return;
            }
    
            let answers = [];
            for (let i = 0; i < answers_div.children.length; i++) {
                let answertext = answers_div.children[i].querySelector(".answer_input").value.trim();
                let iscorrect = answers_div.children[i].querySelector(".answer_checkbox").checked;

                answers.push({ text: answertext, correct: iscorrect });
            }
    
            let file_input = file_picker.querySelector('input[type="file"]');
            let file = file_input.files[0];
            
            let savedQuestion = {
                question: questionText,
                answers: answers,
                file: file
            };
            
            if (isEditing && editingIndex != null){
            savedQuestions[editingIndex] = savedQuestion;
    
            let saved_questions_list = document.getElementById("saved_questions_list");
            let question_list_item = saved_questions_list.children[editingIndex];

            question_list_item.textContent = savedQuestion.question;


            isEditing = false;
            editingIndex = null;
            } else {
                savedQuestions.push(savedQuestion);

                let saved_questions_list = document.getElementById("saved_questions_list");
                let question_list_item = document.createElement('li');
                question_list_item.textContent = savedQuestion.question;
                question_list_item.dataset.index = savedQuestions.length - 1;

                const openModalHandler = () => {
                    open_saved_question_modal(savedQuestions[question_list_item.dataset.index], question_list_item.dataset.index);
                };

                question_list_item.addEventListener('click',openModalHandler);
                saved_questions_list.appendChild(question_list_item);
            }
            
            modal_div.remove();
        });
    
    
        return save_question_button;
    }
 
    function open_saved_question_modal(savedQuestion,index) {
        isEditing = true;
        editingIndex = index;

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

        savedQuestion.answers.forEach(answer => {
            let answer_container = document.createElement('div');
            answer_container.className = "container_for_new_answer";

            let answer_input = document.createElement('input');
            answer_input.className = "answer_input";
            answer_input.value = answer.text;
            answer_input.setAttribute("required", true);

            let answer_checkbox = document.createElement('input');
            answer_checkbox.setAttribute("type", "checkbox");
            answer_checkbox.className = "answer_checkbox";
            answer_checkbox.checked = answer.correct;

            let delete_answer_button = create_element("delete_answer_button", "button", "delete_answer_button", "");

            delete_answer_button.addEventListener('click', () => {
                answer_container.remove();
                answer_count--;
            });

            answer_container.appendChild(answer_checkbox);
            answer_container.appendChild(answer_input);
            answer_container.appendChild(delete_answer_button);

            all_answers_for_question_div.appendChild(answer_container);
        });

        modal_div.appendChild(create_answer_button(all_answers_for_question_div));
        modal_div.appendChild(all_answers_for_question_div);

        modal_div.appendChild(save_question(null,question_input,modal_div,all_answers_for_question_div,file_picker));
        modal_div.appendChild(create_discard_button());
        modal_div.appendChild(create_delete_button(index));


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
                answer_checkbox.className = "answer_checkbox"; 
 
                let delete_answer_button = create_element("delete_answer_button", "button", "delete_answer_button", "");
 
                answer_container.appendChild(answer_checkbox);
                answer_container.appendChild(answer_input);
                answer_container.appendChild(delete_answer_button);

                delete_answer_button.addEventListener('click', () => {
                    answer_container.remove();
                    answer_count--;
                });
 
                parent_element.appendChild(answer_container);
                answer_count++;
            }
        });
        return add_new_answer_to_question;
    }
    
    document.addEventListener('DOMContentLoaded', () => {
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
    
        // Event listener for saved questions
        //document.getElementById('saved_questions_list').addEventListener('click', (event) => {
            //if (event.target.tagName === 'LI') {
            //    const savedQuestion = savedQuestions[event.target.dataset.index]; // Ensure savedQuestions is defined and populated
            //    open_saved_question_modal(savedQuestion);
            //}
        //});
    });

    const saveQuizButton = document.getElementById('saveQuiz');
    if (saveQuizButton) {
        saveQuizButton.addEventListener('click', () => {
            event.preventDefault();
            const urlParams = new URLSearchParams(window.location.search);
            const quizId = urlParams.get('id');

            const data = {
                id: quizId,
                name: document.getElementById('id_name').value,
                intro: document.getElementById('id_quiz_description').value,
                //introformat: document.getElementById('').value, WHAT IS INTRO FORMAT
                timemodified: Date.now(),
                timecreated: Date.now(),
                questions: []
            }

            savedQuestions.forEach((savedQuestion, questionCounter) => {
                const questionData = {
                    id: questionCounter,
                    title: savedQuestion.question,
                    timelimit: savedQuestion.timelimit,
                    explanation: savedQuestion.explanation,
                    answers: []
                }

                savedQuestion.answers.forEach((answer, answerCounter) => {
                    const answerData = {
                    id: answerCounter,
                    correct: answer.correct,
                    description: answer.description,
                    explanation: answer.explanation,
                    };
                    questionData.answers.push(answerData);
                });
                data.questions.push(questionData);
            });
            fetch('/mod/livequiz/quizcreator/save_quiz.php?id='+quizId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(result => {
                console.log('Success:', result);
            })
            .catch(error => {
                console.error('Error:', error);
            })
        })
    }


