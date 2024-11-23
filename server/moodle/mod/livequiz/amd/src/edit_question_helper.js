import Templates from "core/templates";
import { exception as displayException } from "core/notification";

let answer_count = 0;
let IDs = 0;
let isEditing = false;
let editingIndex = 0;

export const add_answer_button_event_listener = ()=> {
    //Adding event listerner to add answer button
    let answer_button = document.querySelector(".add_new_answer_to_question");
    answer_button.addEventListener("click", () => {
        append_answer_input();
    });
}

function append_answer_input() {
    let answer_container = document.createElement("div");
    answer_container.className = "container_for_new_answer";

    let answer_input = document.createElement("input");
    answer_input.className = "answer_input";
    answer_input.placeholder = "Enter answer";
    answer_input.id = "answer_input_" + (IDs + 1);
    answer_input.setAttribute("required", true);

    let answer_checkbox = document.createElement("input");
    answer_checkbox.setAttribute("type", "checkbox");
    answer_checkbox.className = "answer_checkbox";
    answer_checkbox.id = "answer_checkbox_" + (IDs + 1);

    let delete_answer_button = create_element(
        "delete_answer_button",
        "button",
        "delete_answer_button",
        "X"
    );
    delete_answer_button.id = "delete_answer_button_" + (IDs + 1);

    answer_container.appendChild(answer_checkbox);
    answer_container.appendChild(answer_input);
    answer_container.appendChild(delete_answer_button);

    delete_answer_button.addEventListener("click", () => {
        answer_container.remove();
        answer_count--;
    });

    let parent_element = document.querySelector(".all_answers_for_question_div");
    parent_element.appendChild(answer_container);
    answer_count++;
    IDs++;
}

export const add_discard_question_button_listener = () => {
    let discard_question_button = document.querySelector(
        ".discard_question_button"
    );
    discard_question_button.addEventListener("click", () => {
        render_question_confirmation();
    });
}

function render_question_confirmation() {
    Templates.renderForPromise("mod_livequiz/question_confirmation")

        .then(({ html, js }) => {
            Templates.appendNodeContents(".Modal_div", html, js);
            question_confirmation();
        })
        .catch((error) => displayException(error));
}

function question_confirmation() {
    let toast_promise_deletion_div = document.querySelector(
        ".toast_promise_deletion_div"
    );
    let cancel_question_deletion_button = document.querySelector(
        ".cancel_question_deletion_button"
    );
    let continue_question_deletion_button = document.querySelector(
        ".continue_question_deletion_button"
    );

    let modal_div = document.querySelector(".Modal_div");

    continue_question_deletion_button.addEventListener("click", () => {
        isEditing = false;
        editingIndex = null;
        modal_div.remove();
    });

    cancel_question_deletion_button.addEventListener("click", () => {
        toast_promise_deletion_div.remove();
    });
}

function create_element(element_name, type, class_name, content) {
    element_name = document.createElement(type);
    element_name.className = class_name;
    element_name.textContent = content;
    return element_name;
}
