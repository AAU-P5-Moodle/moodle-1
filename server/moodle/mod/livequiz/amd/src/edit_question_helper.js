import Templates from "core/templates";
import {exception as displayException} from "core/notification";

let IDs = 0;

/**
 * Adds an event listener to the "Add Answer" button.
 * When the button is clicked, it appends a new answer input field.
 */
export const addAnswerButtonEventListener = () => {
  // Adding event listener to add answer button
  let answerButton = document.querySelector(".add_new_answer_to_question");
  answerButton.addEventListener("click", () => {
    appendAnswerInput();
  });
};

/**
 * Appends a new answer input container to the container holding all answers
 *
 * This function creates a new answer container with an incremented ID and appends it to the
 * element with the class "all_answers_for_question_div".
 */
export function appendAnswerInput() {
  let answerContainer = createAnswerContainer(IDs + 1);
  let parentElement = document.querySelector(".all_answers_for_question_div");
  parentElement.appendChild(answerContainer);
  IDs++;
}

/**
 * Creates a new answer container element.
 * THIS SHOULD PROBABLY BE MADE INTO MUSTACHE TEMPLATE INSTEAD OF A FUNCTION
 *
 * @param {int} id - The unique identifier for the answer container.
 * @returns {HTMLDivElement} The created answer container element.
 */
export function createAnswerContainer(id) {
  let answerContainer = document.createElement("div");
  answerContainer.className = "container_for_new_answer";

  let answerInput = document.createElement("input");
  answerInput.className = "answer_input";
  answerInput.placeholder = "Enter answer";
  answerInput.id = "answer_input_" + id;
  answerInput.setAttribute("required", true);

  let answerCheckbox = document.createElement("input");
  answerCheckbox.setAttribute("type", "checkbox");
  answerCheckbox.className = "answer_checkbox";
  answerCheckbox.id = "answer_checkbox_" + id;

  let deleteAnswerButton = createElement(
    "delete_answer_button",
    "button",
    "delete_answer_button",
    "X"
  );
  deleteAnswerButton.id = "delete_answer_button_" + id;

  answerContainer.appendChild(answerCheckbox);
  answerContainer.appendChild(answerInput);
  answerContainer.appendChild(deleteAnswerButton);

  deleteAnswerButton.addEventListener("click", () => {
    answerContainer.remove();
  });
  return answerContainer;
}

/**
 * Adds an event listener to the discard question button.
 * When the button is clicked, it triggers the render_question_confirmation function.
 */
export const addDiscardQuestionButtonListener = () => {
  let discardQuestionButton = document.querySelector(
    ".discard_question_button"
  );
  discardQuestionButton.addEventListener("click", () => {
    renderQuestionConfirmation();
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
function renderQuestionConfirmation() {
  Templates.renderForPromise("mod_livequiz/question_confirmation")

    .then(({html, js}) => {
      Templates.appendNodeContents(".Modal_div", html, js);
      questionConfirmation();
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
function questionConfirmation() {
  let toastPromiseDeletionDiv = document.querySelector(
    ".toast_promise_deletion_div"
  );
  let cancelQuestionDeletionButton = document.querySelector(
    ".cancel_question_deletion_button"
  );
  let continueQuestionDeletionButton = document.querySelector(
    ".continue_question_deletion_button"
  );

  let modalDiv = document.querySelector(".Modal_div");

  continueQuestionDeletionButton.addEventListener("click", () => {
    modalDiv.remove();
  });

  cancelQuestionDeletionButton.addEventListener("click", () => {
    toastPromiseDeletionDiv.remove();
  });
}

/**
 * Creates a new HTML element with the specified type, class, and content.
 *
 * @param {HTMLElement} elementName - The variable to hold the created element.
 * @param {string} type - The type of the HTML element to create (e.g., 'div', 'span').
 * @param {string} className - The class name to assign to the created element.
 * @param {string} content - The text content to set for the created element.
 * @returns {HTMLElement} The newly created HTML element.
 */
function createElement(elementName, type, className, content) {
  elementName = document.createElement(type);
  elementName.className = className;
  elementName.textContent = content;
  return elementName;
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
export function rerenderSavedQuestionsList(questions, callback) {
  // The template needs to know the questions to render.
  const contextSavedQuestions = {
    questions: questions,
  };

  // Remove the saved questions list.
  let questionsList = document.querySelector("#saved_questions_list");
  questionsList.remove();

  // Re-render saved questions list.
  Templates.renderForPromise(
    "mod_livequiz/saved_questions_list",
    contextSavedQuestions
  )
    .then(({html, js}) => {
      Templates.appendNodeContents("#saved-questions-container", html, js);

      // Call the functions in callback, this allows for custom functions to be called after the rerendering.
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
 * @param {boolean} hasQuestions - Indicates if the quiz has questions.
 * @param {function} [callback] - Optional callback function to execute after re-rendering.
 */

/**
 *
 * @param url
 * @param hasQuestions
 * @param callback
 */
export function rerenderTakeQuizButton(url, hasQuestions, callback) {
  // The template needs to know if there are questions in the quiz.
  // If there are questions -> Create a button to redirect to the quiz.
  // If there are no questions -> Display a paragraph that says there are no questions.

  const contextTakeQuiz = {
    url: url,
    hasquestions: hasQuestions,
  };

  if (hasQuestions) {
    // Remove no question paragraph if there are questions.
    let noQuestionParagraph = document.querySelector(".no-question-text");
    if (noQuestionParagraph) {
      noQuestionParagraph.remove(); // We have just added a question so remove the no question text
    } else {
      let takeQuizButton = document.querySelector("#takeQuizBtn");
      takeQuizButton.remove();
    }
  } else {
    // Remove take quiz link if there are no questions
    let takeQuizButton = document.querySelector("#takeQuizBtn");
    takeQuizButton.remove();
  }

  Templates.renderForPromise("mod_livequiz/take_quiz_button", contextTakeQuiz)
    // It returns a promise that needs to be resolved.
    .then(({html, js}) => {
      // Here we have compiled template.
      Templates.appendNodeContents("#page-mod-livequiz-quizcreator", html, js);
      if (typeof callback === "function") {
        callback();
      }
    })

    // Deal with this exception (Using core/notify exception function is recommended).
    .catch((error) => displayException(error));
}
