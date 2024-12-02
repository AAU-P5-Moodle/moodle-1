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

  let questionType = document.getElementById("question_type_checkbox_id").checked ? 1 : 0;

  if (!questionDesription) {
    alert("Please enter a question description.");
    return;
  }
  if (!questionTitle) {
    questionTitle = "Question";
  }

  let answers = prepare_answers();

  let savedQuestion = {
    id: 0,
    title: questionTitle,
    answers: answers,
    description: questionDesription,
    explanation: questionExplanation,
    type: questionType,
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
