import Templates from "core/templates";
import {exception as displayException} from "core/notification";
import {saveQuestion} from "./repository";
import {addDeleteQuestionListeners} from "./delete_question";
import {addEditQuestionListeners} from "./edit_question";
import {
  addAnswerButtonEventListener,
  addCancelEditButtonListener,
  rerenderSavedQuestionsList,
  rerenderTakeQuizButton,
  validateSubmission,
  getQuestionData,
  prepareAnswers,
} from "./helper";

let takeQuizUrl = "";

/**
 * Adds an event listener to the "Add Question" button.
 * When the button is clicked, it renders the create question menu popup.
 *
 * @param {number} quizId - The ID of the quiz.
 * @param {number} lecturerId - The ID of the lecturer.
 * @param {string} url - The URL to the quiz attempt page.
 * @returns {Promise<void>} A promise that resolves when the initialization is complete.
 */
export const init = async(quizId, lecturerId, url) => {
  takeQuizUrl = url; // Set url to quiz attempt page to global variable
  let addQuestionButton = document.getElementById("id_buttonaddquestion");
  addQuestionButton.addEventListener("click", () => {
    renderCreateQuestionMenuPopup(quizId, lecturerId);
  });
};

/**
 * Renders the create question menu popup for a live quiz.
 *
 * This function loads and renders the question menu popup template, appends it to the main container,
 * Sets up event listeners for adding answers, saving the question, and discarding the question.
 *
 * @param {number} quizId - The ID of the quiz.
 * @param {number} lecturerId - The ID of the lecturer.
 * @returns {void}
 */
function renderCreateQuestionMenuPopup(quizId, lecturerId) {
  // This will call the function to load and render our template.
  if (!document.querySelector('.Modal_div')) {
    Templates.renderForPromise("mod_livequiz/question_menu_popup",null,"boost")

      // It returns a promise that needs to be resolved.
      .then(({html, js}) => {
        // Here we have compiled template.
        Templates.appendNodeContents(".main-container", html, js);
        addAnswerButtonEventListener();
        addSaveQuestionButtonListener(quizId, lecturerId);
        addCancelEditButtonListener("create");
      })

      // Deal with this exception (Using core/notify exception function is recommended).
      .catch((error) => displayException(error));
  }
}

/**
 * Adds an event listener to the save question button
 *
 * @param {number} quizId - The ID of the quiz.
 * @param {number} lecturerId - The ID of the lecturer.
 */
function addSaveQuestionButtonListener(quizId, lecturerId) {
  let saveQuestionButton = document.querySelector(".save_button");
  saveQuestionButton.addEventListener("click", () => {
    handleQuestionSubmission(quizId, lecturerId);
  });
}

/**
 *
 * @param quizId
 * @param lecturerId
 */
function handleQuestionSubmission(quizId, lecturerId) {
  let savedQuestion = prepareQuestion(); // Prepare the question object to be sent to DB

    if(!validateSubmission(savedQuestion.answers)) {
    return;
  }

  let updateEventListeners = () => {
    addEditQuestionListeners(quizId, lecturerId);
    addDeleteQuestionListeners(quizId, lecturerId);
  };

  saveQuestion(savedQuestion, lecturerId, quizId).then((questions) => {
    rerenderSavedQuestionsList(questions, updateEventListeners); // Re-render saved questions list
    rerenderTakeQuizButton(takeQuizUrl, true); // Re-render take quiz button
  });

  let modalDiv = document.querySelector(".Modal_div");
  modalDiv.remove();
}

/**
 *
 */
function prepareQuestion() {
  let questionData = getQuestionData();

  return {
    id: 0,
    title: questionData.title,
    answers: prepareAnswers(),
    description: questionData.description,
    explanation: questionData.explanation,
    type: questionData.type,
  };
}
