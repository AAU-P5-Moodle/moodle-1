import Templates from "core/templates";
import {exception as displayException} from 'core/notification';
import {save_question} from "./repository";

let isEditing = false;
let editingIndex = 0;
let answer_count = 0;

export const init = async (quizid, lecturerid) => {
  let add_question_button = document.getElementById("id_buttonaddquestion");
  add_question_button.addEventListener("click", () => {
    render_question_menu_popup(quizid, lecturerid);
  });
};

function render_question_menu_popup(quizid, lecturerid) {
  // This will call the function to load and render our template.
  Templates.renderForPromise("mod_livequiz/question_menu_popup")

    // It returns a promise that needs to be resoved.
    .then(({ html, js }) => {
      // Here eventually I have my compiled template, and any javascript that it generated.
      // The templates object has append, prepend and replace functions.
      Templates.appendNodeContents(".main-container", html, js);
      add_answer_button_event_listerner();
      add_save_question_button_listener(quizid, lecturerid);
      add_discard_question_button_listener();
    })

    // Deal with this exception (Using core/notify exception function is recommended).
    .catch((error) => displayException(error));
}

function add_answer_button_event_listerner() {
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
  answer_input.placeholder = "Enter answer " + (answer_count + 1);
  answer_input.id = "answer_input_" + (answer_count + 1);
  answer_input.setAttribute("required", true);


  let answer_checkbox = document.createElement("input");
  answer_checkbox.setAttribute("type", "checkbox");
  answer_checkbox.className = "answer_checkbox";
  answer_checkbox.id = "answer_checkbox_" + (answer_count + 1);

  let delete_answer_button = create_element(
    "delete_answer_button",
    "button",
    "delete_answer_button",
    ""
  );

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
}

function add_save_question_button_listener(quizid, lecturerid) {
  let save_question_button = document.querySelector(".save_button");
  save_question_button.addEventListener("click", () => {question_button(quizid, lecturerid);});
}

function question_button(quizid, lecturerid){
    let question_input = document.querySelector(".question_input_large");
    let questionText = question_input.value.trim();

    if (!questionText) {
      alert("Please enter a question.");
      return;
    }

    let answers = [];
    let answers_div = document.querySelector(".all_answers_for_question_div");
    for (let i = 0; i < answers_div.children.length; i++) {
      let answertext = answers_div.children[i]
        .querySelector(".answer_input")
        .value.trim();

      let iscorrect = answers_div.children[i].querySelector(".answer_checkbox").checked;
      iscorrect ? iscorrect = 1 : iscorrect = 0;


      answers.push({
        description: answertext,
        correct: iscorrect,
        explanation: "",
      });
    }

    let savedQuestion = {
      title: questionText,
      answers: answers,
      description: "",
      explanation: "",
    };

    save_question(savedQuestion, lecturerid, quizid);
    let modal_div = document.querySelector(".Modal_div");
    console.log(savedQuestion);
    modal_div.remove();
}

function add_discard_question_button_listener() {
  let discard_question_button = document.querySelector(".discard_question_button");
  console.log(discard_question_button);
  discard_question_button.addEventListener('click', () => {
    render_question_confirmation();
  });
}

function render_question_confirmation() {
  console.log("GOT INTO LISTENER");
  Templates.renderForPromise("mod_livequiz/question_confirmation")

  .then(({ html, js }) => {
    Templates.appendNodeContents(".Modal_div", html, js);
    question_confirmation();
  })
  .catch((error) => displayException(error));
}

function question_confirmation() {
  let toast_promise_deletion_div = document.querySelector(".toast_promise_deletion_div");
  let cancel_question_deletion_button = document.querySelector(".cancel_question_deletion_button");
  let continue_question_deletion_button = document.querySelector(".continue_question_deletion_button");

  let modal_div = document.querySelector('.Modal_div');

  continue_question_deletion_button.addEventListener('click', () => {
    isEditing = false;
    editingIndex = null
    modal_div.remove();
  });

  cancel_question_deletion_button.addEventListener('click', () => {
    toast_promise_deletion_div.remove();
  });
}

function create_element(element_name, type, class_name, content) {
  element_name = document.createElement(type);
  element_name.className = class_name;
  element_name.textContent = content;
  return element_name;
}