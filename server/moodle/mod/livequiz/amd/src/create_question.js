import Templates from "core/templates";
import { exception as displayException } from "core/notification";
import { save_question } from "./repository";
import { add_delete_question_listeners } from "./delete_question";
import { add_edit_question_listeners } from "./edit_question";
import {
  rerender_take_quiz_button,
  rerender_saved_questions_list,
  add_answer_button_event_listener,
  add_discard_question_button_listener,
} from "./edit_question_helper";

let isEditing = false;
let editingIndex = 0;
let answer_count = 0;
let IDs = 0;
let take_quiz_url = "";

/**
 * Adds an event listener to the "Add Question" button.
 * When the button is clicked, it renders the create question menu popup.
 *
 * @param {number} quizid - The ID of the quiz.
 * @param {number} lecturerid - The ID of the lecturer.
 * @param {string} url - The URL to the quiz attempt page.
 * @returns {Promise<void>} A promise that resolves when the initialization is complete.
 */
export const init = async (quizid, lecturerid, url) => {
  take_quiz_url = url; //Set url to quiz attempt page to global variable
  let add_question_button = document.getElementById("id_buttonaddquestion");
  add_question_button.addEventListener("click", () => {
    render_create_question_menu_popup(quizid, lecturerid);
  });
};

/**
 * Renders the create question menu popup for a live quiz.
 *
 * This function loads and renders the question menu popup template, appends it to the main container,
 * Sets up event listeners for adding answers, saving the question, and discarding the question.
 *
 * @param {number} quizid - The ID of the quiz.
 * @param {number} lecturerid - The ID of the lecturer.
 * @returns {void}
 */
function render_create_question_menu_popup(quizid, lecturerid) {
  // This will call the function to load and render our template.
  Templates.renderForPromise("mod_livequiz/question_menu_popup")

    // It returns a promise that needs to be resoved.
    .then(({ html, js }) => {
      // Here we have compiled template.
      Templates.appendNodeContents(".main-container", html, js);
      add_answer_button_event_listener();
      add_save_question_button_listener(quizid, lecturerid);
      add_discard_question_button_listener();
    })

    // Deal with this exception (Using core/notify exception function is recommended).
    .catch((error) => displayException(error));
}

/**
 * Adds an event listener to the save question button
 *
 * @param {number} quizid - The ID of the quiz.
 * @param {number} lecturerid - The ID of the lecturer.
 */
function add_save_question_button_listener(quizid, lecturerid) {
  let save_question_button = document.querySelector(".save_button");
  save_question_button.addEventListener("click", () => {
    handle_question_submission(quizid, lecturerid);
  });
}

function handle_question_submission(quizid, lecturerid) {
  let savedQuestion = prepare_question(); //Prepare the question object to be sent to DB

  if(!validate_submission(savedQuestion.answers)) {
    return;
  }

  let update_event_listeners = () => {
    add_edit_question_listeners(quizid, lecturerid);
    add_delete_question_listeners(quizid, lecturerid);
  }

  save_question(savedQuestion, lecturerid, quizid).then((questions) => {
    rerender_saved_questions_list(questions, update_event_listeners); //Re-render saved questions list
    rerender_take_quiz_button(take_quiz_url, true); //Re-render take quiz button
  });

  let modal_div = document.querySelector(".Modal_div");
  modal_div.remove();
}

function prepare_question() {
  let question_input_title = document.getElementById("question_title_id");
  let question_indput_description = document.getElementById(
    "question_description_id"
  );
  let question_indput_explanation = document.getElementById(
    "question_explanation_id"
  );
  let questionTitle = question_input_title.value.trim();
  let questionDesription = question_indput_description.value.trim();
  let questionExplanation = question_indput_explanation.value.trim();


  let answers = prepare_answers();

  // CHECK HERE IF THE QUESTION IS VALID
  let savedQuestion = {
    id: 0,
    title: questionTitle,
    answers: answers,
    description: questionDesription,
    explanation: questionExplanation,
  };

  return savedQuestion;
}

function prepare_answers() {
  let answers = [];
  let answers_div = document.querySelector(".all_answers_for_question_div");

  for (let i = 0; i < answers_div.children.length; i++) {
    let answertext = answers_div.children[i]
        .querySelector(".answer_input")
        .value.trim();

    let iscorrect =
        answers_div.children[i].querySelector(".answer_checkbox").checked;
    iscorrect = iscorrect ? 1 : 0;

      answers.push({
        description: answertext,
        correct: iscorrect,
        explanation: "",
      });
  }
  return answers;
}

function validate_submission(answers) {
  let isValid = true;
  let isAnswerValid = true;
  let alertMessage = [];
  let questionTitle = document.getElementById("question_title_id").value.trim();
  let questionTitleTextarea = document.getElementById("question_title_id");
  let questionDesription = document.getElementById("question_description_id").value.trim();
  let questionDesriptionTextarea = document.getElementById("question_description_id");

  const setBorderStyle = (element, isValid) => {
    element.style.border = isValid ? "1px solid #ccc" : "1px solid red";
  };

  if (!questionTitle) {
    setBorderStyle(questionTitleTextarea, !!questionTitle);
    alertMessage.push("Please enter a question title.");
    isValid = false;
  } else {
    setBorderStyle(questionTitleTextarea, true);
  }
  if (!questionDesription) {
    setBorderStyle(questionDesriptionTextarea, !!questionDesription);
    alertMessage.push("Please enter a question description.");
    isValid = false;
  } else {
    setBorderStyle(questionDesriptionTextarea, true);
  }

  if (answers.length < 2) {
    isValid = false;
    alertMessage.push("Please enter at least two answers.");
  }

  if (!answers.some(answer => answer.correct === 1)) {
    isValid = false;
    alertMessage.push("Please select at least one correct answer.");
  }

  if (answers.some(answer => !answer.description.trim())) {
    isValid = false;
    alertMessage.push("Each answer must have a description.");
  }

  if(!isValid) {
    alert(alertMessage.join("\n"));
    return false;
  }
  return true;
}