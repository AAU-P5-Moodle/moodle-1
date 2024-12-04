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
export function append_answer_input() {
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
  // The template needs to know the questions to render.
  const contextsavedquestions = {
    questions: questions,
  };

  // Remove the saved questions list.
  let questions_list = document.querySelector("#saved_questions_list");
  questions_list.remove();

  // Re-render saved questions list.
  Templates.renderForPromise(
    "mod_livequiz/saved_questions_list",
    contextsavedquestions
  )
    .then(({ html, js }) => {
      Templates.appendNodeContents("#saved_questions_container", html, js);

      // Call the functions in callback, this allows for custom functions to be called after the rerendering.
      if (typeof callback === "function") {
        callback();
      }
    })
    .catch((error) => console.log(error));
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
    let no_question_paragraph = document.querySelector(".no_question_text");
    if (no_question_paragraph) {
      no_question_paragraph.remove(); //We have just added a question so remove the no question text
    } else {
      let take_quiz_button = document.querySelector("#take_quiz_button");
      take_quiz_button.remove();
    }
  } else {
    //Remove take quiz link if there are no questions
    let take_quiz_button = document.querySelector("#take_quiz_button");
    take_quiz_button.remove();
  }

  Templates.renderForPromise("mod_livequiz/take_quiz_button", contexttakequiz)
    // It returns a promise that needs to be resoved.
    .then(({ html, js }) => {
      // Here we have compiled template.
      Templates.appendNodeContents("#page_mod_livequiz_quizcreator", html, js);
      if (typeof callback === "function") {
        callback();
      }
    })

    // Deal with this exception (Using core/notify exception function is recommended).
    .catch((error) => displayException(error));
}

/**
 * Sets up the event listener for the cancel button
 * @param {string} context - The context in which the cancel button is being used.
 */
export function add_cancel_edit_button_listener(context) {
  let cancel_question_button = document.querySelector(
      ".cancel_question_button"
  );
  let modal_div = document.querySelector(".modal_div");
  let stringForConfirm = "";

  // Set the string for the confirm box based on the context.
  switch (context) {
    case "create":
      stringForConfirm = "Are you sure you want to cancel creating the question?";
      break;
    case "edit":
      stringForConfirm = "Are you sure you want to cancel editing the question?";
      break;
    case "import":
      stringForConfirm = "Are you sure you want to cancel importing the question?";
      break;
    default:
      stringForConfirm = "Are you sure you want to cancel the changes made?";
  }
  cancel_question_button.addEventListener("click", () => {
    if(confirm(stringForConfirm)) {
      isEditing = false;
      editingIndex = null;
      modal_div.remove();
    }
    else {
      return;
    }
  });
}


/**
 * This validates that all inputs to create/edit question, if not all inputs are satisfied, it will return false.
 * @param answers The answers of the question.
 * @returns {boolean} True if input fields are satisfied, false otherwise.
 */
export function validate_submission(answers) {
  let isValid = true; // Is the question valid.
  let answersValid = true; // Are all the answers valid.
  let questionTitle = document.getElementById("question_title_id").value.trim();
  let questionTitleTextarea = document.getElementById("question_title_id");
  let questionTitleAlert = document.getElementById("title_textarea_alert");
  let questionDesription = document.getElementById("question_description_id").value.trim();
  let questionDesriptionTextarea = document.getElementById("question_description_id");
  let questionDescriptionAlert = document.getElementById("question_textarea_alert");
  let atLeastOneCorrectAnswerAlert = document.getElementById("question_alert_one_correct");
  let answerDescriptionAlert = document.getElementById("question_alert_description");
  let atLeastTwoAnswersAlert = document.getElementById("question_alert_two_answers");
  let maxOneCorrectAnswerAlert = document.getElementById("question_alert_max_one_correct");
  let questionType = document.getElementById("question_type_checkbox_id").checked;
  let answersBox = document.getElementById("all_answers");
  let isValidText = document.getElementById("valid_text");

  // Function to set the border style of an element.
  const setBorderStyle = (element, isValid) => {
    element.style.border = isValid ? "1px solid #ccc" : "1px solid red";
  };

  // Checks if the question title is empty.
  if (!questionTitle) {
    setBorderStyle(questionTitleTextarea, !!questionTitle);
    questionTitleAlert.style.display = "block";
    isValid = false;
  } else {
    questionTitleAlert.style.display = "none";
    setBorderStyle(questionTitleTextarea, true);
  }

    // Checks if the question description is empty.
  if (!questionDesription) {
    setBorderStyle(questionDesriptionTextarea, !!questionDesription);
    questionDescriptionAlert.style.display = "block";
    isValid = false;
  } else {
    questionDescriptionAlert.style.display = "none";
    setBorderStyle(questionDesriptionTextarea, true);
  }

  // Checks if there are at least two answers.
  if (answers.length < 2) {
    isValid = false;
    answersValid = false;
    atLeastTwoAnswersAlert.style.display = "block";
  }
  else {
    atLeastTwoAnswersAlert.style.display = "none";
  }

  // Checks if at least one answer is correct.
  if (!answers.some(answer => answer.correct === 1)) {
    isValid = false;
    answersValid = false;
    atLeastOneCorrectAnswerAlert.style.display = "block";
  }
  else {
    atLeastOneCorrectAnswerAlert.style.display = "none";
  }

  // Checks if all answers have a description.
  if (answers.some(answer => !answer.description.trim())) {
    isValid = false;
    answersValid = false;
    answerDescriptionAlert.style.display = "block";
  } else {
    answerDescriptionAlert.style.display = "none";
  }

  // Checks if multiple correct answers have been set, when not allowed to.
  if (questionType) {
    let checkedAnswers = 0;
    answers.forEach(answer => {
      checkedAnswers += answer.correct;
    });
    if (checkedAnswers > 1){
      isValid = false;
      answersValid = false;
      maxOneCorrectAnswerAlert.style.display = "block";
    } else {
      maxOneCorrectAnswerAlert.style.display = "none";
    }
  } else {
    maxOneCorrectAnswerAlert.style.display = "none";
  }

  if (!answersValid) { // If not all answers are valid show the box with warnings.
    answersBox.style.display = "block";
  } else {
    answersBox.style.display = "none";
  }

  if (!isValid) { // If the question is not valid show warning.
    isValidText.style.display = "block";
    return false;
  }
  return true;
}
