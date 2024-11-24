import Templates from "core/templates";
import { exception as displayException } from "core/notification";

let IDs = 0;
let isEditing = false;
let editingIndex = 0;

/**
 * Adds an event listener to the "Add Answer" button.
 * When the button is clicked, it appends a new answer input field.
 */
export const add_answer_button_event_listener = () => {
  //Adding event listerner to add answer button
  let answer_button = document.querySelector(".add_new_answer_to_question");
  answer_button.addEventListener("click", () => {
    append_answer_input();
  });
};

/**
 * Appends a new answer input container to the container holding all answers
 * 
 * This function creates a new answer container with an incremented ID and appends it to the 
 * element with the class "all_answers_for_question_div".
 */
function append_answer_input() {
  let answer_container = create_answer_container(IDs + 1);
  let parent_element = document.querySelector(".all_answers_for_question_div");
  parent_element.appendChild(answer_container);
  IDs++;
}

/**
 * Creates a new answer container element.
 * THIS SHOULD PROBABLY BE MADE INTO MUSTACHE TEMPLATE INSTEAD OF A FUNCTION
 *
 * @param {string} id - The unique identifier for the answer container.
 * @returns {HTMLDivElement} The created answer container element.
 */
export function create_answer_container(id) {
  let answer_container = document.createElement("div");
  answer_container.className = "container_for_new_answer";

  let answer_input = document.createElement("input");
  answer_input.className = "answer_input";
  answer_input.placeholder = "Enter answer";
  answer_input.id = "answer_input_" + id;
  answer_input.setAttribute("required", true);

  let answer_checkbox = document.createElement("input");
  answer_checkbox.setAttribute("type", "checkbox");
  answer_checkbox.className = "answer_checkbox";
  answer_checkbox.id = "answer_checkbox_" + id;

  let delete_answer_button = create_element(
    "delete_answer_button",
    "button",
    "delete_answer_button",
    "X"
  );
  delete_answer_button.id = "delete_answer_button_" + id;

  answer_container.appendChild(answer_checkbox);
  answer_container.appendChild(answer_input);
  answer_container.appendChild(delete_answer_button);

  delete_answer_button.addEventListener("click", () => {
    answer_container.remove();
  });
  return answer_container;
}

/**
 * Adds an event listener to the discard question button.
 * When the button is clicked, it triggers the render_question_confirmation function.
 */
export const add_discard_question_button_listener = () => {
  let discard_question_button = document.querySelector(
    ".discard_question_button"
  );
  discard_question_button.addEventListener("click", () => {
    render_question_confirmation();
  });
};

/**
 * Renders the question confirmation modal.
 *
 * Renders "mod_livequiz/question_confirmation" template.
 * Appends the HTML and JavaScript to the ".Modal_div" element
 * Calls the `question_confirmation` function
 *
 * @function
 * @returns {void}
 */
function render_question_confirmation() {
  Templates.renderForPromise("mod_livequiz/question_confirmation")

    .then(({ html, js }) => {
      Templates.appendNodeContents(".Modal_div", html, js);
      question_confirmation();
    })
    .catch((error) => displayException(error));
}

/**
 * Handles the confirmation process for deleting a question.
 * 
 * This function sets up event listeners for the yes and no buttons when discarding a question.
 * When yes is clicked, the editing menu is removed
 * When no is clicked, the confirmation pop-up is removed
 * 
 * @function question_confirmation
 */
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

/**
 * Creates a new HTML element with the specified type, class, and content.
 *
 * @param {HTMLElement} element_name - The variable to hold the created element.
 * @param {string} type - The type of the HTML element to create (e.g., 'div', 'span').
 * @param {string} class_name - The class name to assign to the created element.
 * @param {string} content - The text content to set for the created element.
 * @returns {HTMLElement} The newly created HTML element.
 */
function create_element(element_name, type, class_name, content) {
  element_name = document.createElement(type);
  element_name.className = class_name;
  element_name.textContent = content;
  return element_name;
}

/**
 * Rerenders the saved questions list.
 *
 * This function removes the existing saved questions list from the DOM,
 * Renders the "mod_livequiz/saved_questions_list" template with the provided questions
 * After re-rendering, it calls the provided callback function, if any.
 *
 * @param {Array} questions - An array of question objects to be rendered.
 * @param {Function} [callback] - An optional callback function to be executed after the list is re-rendered.
 */
export function rerender_saved_questions_list(questions, callback) {
  //The template needs to know the questions to render.
  const contextsavedquestions = {
    questions: questions,
  };

  //Remove the saved questions list.
  let questions_list = document.querySelector("#saved_questions_list");
  questions_list.remove();

  //Re-render saved questions list.
  Templates.renderForPromise(
    "mod_livequiz/saved_questions_list",
    contextsavedquestions
  )
    .then(({ html, js }) => {
      Templates.appendNodeContents("#saved-questions-container", html, js);

      //Call the functions in callback, this allows for custom functions to be called after the rerendering.
      if (typeof callback === "function") {
        callback();
      }
    })
    .catch((error) => displayException(error));
}

/**
 * Renders the "mod_livequiz/take_quiz_button" template based on whether there are questions in the quiz.
 *
 * @param {string} url - The URL for the "Take Quiz" button to redirect to.
 * @param {boolean} hasquestions - Indicates if the quiz has questions.
 * @param {function} [callback] - Optional callback function to execute after re-rendering.
 */

export function rerender_take_quiz_button(url, hasquestions, callback) {
  //The template needs to know if there are questions in the quiz.
  //If there are questions -> Create a button to redirect to the quiz.
  //If there are no questions -> Display a paragraph that says there are no questions.

  const contexttakequiz = {
    url: url,
    hasquestions: hasquestions,
  };

  if (hasquestions) {
    //Remove no question paragraph if there are questions.
    let no_question_paragraph = document.querySelector(".no-question-text");
    no_question_paragraph.remove(); //We have just added a question so remove the no question text
  } else {
    //Remove take quiz link if there are no questions
    let take_quiz_button = document.querySelector("#takeQuizBtn");
    console.log(take_quiz_button);
    take_quiz_button.remove();
  }

  Templates.renderForPromise("mod_livequiz/take_quiz_button", contexttakequiz)
    // It returns a promise that needs to be resoved.
    .then(({ html, js }) => {
      // Here we have compiled template.
      Templates.appendNodeContents("#page-mod-livequiz-quizcreator", html, js);
      if (typeof callback === "function") {
        callback();
      }
    })

    // Deal with this exception (Using core/notify exception function is recommended).
    .catch((error) => displayException(error));
}
