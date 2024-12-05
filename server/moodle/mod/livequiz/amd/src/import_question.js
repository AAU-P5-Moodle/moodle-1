import Templates from "core/templates";
import { exception as displayException } from "core/notification";
import {addCancelEditButtonListener, rerenderSavedQuestionsList, rerenderTakeQuizButton} from "./helper";
import {addEditQuestionListeners} from "./edit_question";
import {addDeleteQuestionListeners} from "./delete_question";
import {externalReuseQuestions, getLecturerQuiz} from "./repository";

/**
 * Adds an event listener to the "Import Question" button.
 * When the button is clicked, it renders the import question menu popup.
 *
 * @param {number} quizId - The ID of the quiz.
 * @param {number} lecturerId - The ID of the lecturer.
 * @param {string} url - The URL to the quiz attempt page.
 * @returns {Promise<void>} A promise that resolves when the initialization is complete.
 */
export const init = async(quizId, lecturerId, url) => {
    let importQuestionButton = document.getElementById("import_question_button");
    importQuestionButton.addEventListener("click", () => {
        renderImportQuestionMenuPopup(quizId, lecturerId, url);
    });
};

/**
 * Renders the import question menu popup for a live quiz.
 *
 * This function loads and renders the import question menu popup template, appends it to the main container,
 * Sets up event listeners for importing questions and cancelling the import.
 *
 * @param {number} quizId - The ID of the quiz.
 * @param {number} lecturerId - The ID of the lecturer.
 * @param {string} url - The URL to the quiz attempt page.
 * @returns {void} - Nothing.
 */
function renderImportQuestionMenuPopup(quizId, lecturerId, url) {
    // This will call the function to load and render our template.
    if (!document.querySelector(".modal_div")) {
        Templates.renderForPromise("mod_livequiz/import_question_popup", {}, "boost")
            // It returns a promise that needs to be resolved.
            .then(({ html, js }) => {
                // Here we have compiled template.
                Templates.appendNodeContents(".main_container", html, js);
                importQuestions(quizId, url, lecturerId);
                addCancelEditButtonListener("import");
                addOldQuestionsToPopup(lecturerId, quizId);
            })

            // Deal with this exception (Using core/notify exception function is recommended).
            .catch((error) => displayException(error));
    }
}

/**
 * Adds old questions to the import question popup.
 *
 * @param {number} lecturerId - The ID of the lecturer.
 * @param {number} quizId - The ID of the quiz.
 * @returns {void}
 */
function addOldQuestionsToPopup(lecturerId, quizId) {
    getLecturerQuiz(lecturerId)
        .then((oldQuizzes) => {
            // Filter out the current quiz, so you can't import questions from the same quiz.
            oldQuizzes = oldQuizzes.filter((currentquiz) => currentquiz.quizid !== quizId);

            // Check how many questions are available.
            let oldQuizzesContainer = document.querySelector(".old_quizzes");
            if (oldQuizzes.length === 0) {
                let noQuestions = document.createElement("p");
                noQuestions.textContent = "No questions available.";
                oldQuizzesContainer.appendChild(noQuestions);
                return;
            }

            //Otherwise, loop through all quizzes and add the questions to the popup.
            oldQuizzes.forEach((quiz) => {
                let quiz_context = {
                    quizid: quiz.quizid,
                    quiztitle: quiz.quiztitle,
                    questions: quiz.questions,
                };
                if (quiz.questions.length > 0) {
                    Templates.renderForPromise("mod_livequiz/import_questions_list", quiz_context)
                        .then(({ html, js }) => {
                            Templates.appendNodeContents(".old_quizzes", html, js);
                            addQuizCheckboxListener(quiz.quizid);
                            addQuestionCheckboxListener(quiz.quizid);
                            addQuestionEntryListeners(quiz.quizid);
                        })
                        .catch((error) => displayException(error));
                }
            });
        })
        .catch((error) => displayException(error));
}

/**
 * Imports questions into a quiz.
 *
 * @param {number} quizId - The ID of the quiz.
 * @param {number} quizId - The ID of the quiz.
 * @param {string} url - The URL of the quiz page.
 * @param {number} lecturerId - The ID of the lecturer.
 * @param {number} lecturerId - The ID of the lecturer.
 * @returns {Promise<void>} A promise that resolves when the questions are imported.
 */
async function importQuestions(quizId, url, lecturerId) {
    let quizUrl = url;
    const importQuestionBtn = document.querySelector(".import_question_button");

    importQuestionBtn.addEventListener("click", async () => {
        try {
            let questionIds = getCheckedQuestions();
            if (questionIds.length === 0) {
                alert("No questions selected. Please choose at least one question to import.");
                return;
            }
            callReuseQuestions(quizId, questionIds, lecturerId, quizUrl);
        } catch (error) {
            displayException(error);
        }
    });
}

/**
 * Calls the external function to reuse questions.
 *
 @param {number} quizId - The ID of the quiz.
 @param {Array<number>} questionIds - The IDs of the questions to reuse.
 @param {number} lecturerId - The ID of the lecturer.
 @param {string} quizUrl - The URL of the quiz page.
 @returns {void}
 */
function callReuseQuestions(quizId, questionIds, lecturerId, quizUrl) {
    externalReuseQuestions(quizId, questionIds, lecturerId)
        .then((questions) => {
            let updateEventListeners = () => {
                addEditQuestionListeners(quizId, lecturerId);
                addDeleteQuestionListeners(quizId, lecturerId);
            };
            rerenderSavedQuestionsList(questions, updateEventListeners); // Re-render saved questions list.
            // Re-render take quiz button. Since at least one question was imported, hasquestions is true.
            rerenderTakeQuizButton(quizUrl, true);
        })
        .catch((error) => displayException(error));
    let popupMenu = document.querySelector(".backdrop");
    popupMenu.remove();
}

/**
 * Retrieves the values of all checked questions from the lecturer's question list.
 *
 * @returns {Array<number>} An array containing the ids of the checked questions.
 */
function getCheckedQuestions() {
    let checkedquestions = [];
    let questions = document.querySelectorAll(".question_checkbox");
    questions.forEach((question) => {
        if (question.checked) {
            // If the checkbox is checked, add the id to the array.
            checkedquestions.push(parseInt(question.id));
        }
    });

    return checkedquestions; // Returns the checked questions.
}

/**
 * Adds an event listener to the quiz checkboxes.
 * Marks all questions as checked if the quiz checkbox is checked
 * @param {number} quizId - The ID of the quiz, used to identify the checkboxes.
 */
function addQuizCheckboxListener(quizId) {
    let quizCheckbox = document.querySelector(".quiz_" + quizId);
    let questionCheckboxes = document.querySelectorAll(".quiz_" + quizId + "_question");

    quizCheckbox.addEventListener("change", () => {
        questionCheckboxes.forEach((questionCheckbox) => {
            questionCheckbox.checked = quizCheckbox.checked; // Set all questions to checked if the quiz is checked.
            if (questionCheckbox.checked) {
                let questionEntry = questionCheckbox.parentElement;
                questionEntry.classList.add("question_selected");
            } else {
                let questionEntry = questionCheckbox.parentElement;
                questionEntry.classList.remove("question_selected");
            }
        });
    });
}

/**
 * Adds an event listener to the question checkboxes.
 * If all questions are checked, the quiz checkbox is checked.
 * If a question is unchecked, the quiz checkbox is unchecked.
 * @param {number} quizId - The ID of the quiz, used to identify the checkboxes.
 */
function addQuestionCheckboxListener(quizId) {
    let quizCheckbox = document.querySelector(".quiz_" + quizId);
    let questionCheckboxes = document.querySelectorAll(".quiz_" + quizId + "_question");

    questionCheckboxes.forEach((questionCheckbox) => {
        questionCheckbox.addEventListener("click", (event) => {
            questionCheckbox.checked = !questionCheckbox.checked;
        });

        questionCheckbox.addEventListener("change", () => {
            let questionEntry = questionCheckbox.parentElement;

            if (questionCheckbox.checked) {
                questionEntry.classList.add("question_selected");
                // If the question is checked, check if all questions are checked.
                let allChecked = false;
                allChecked = areAllQuestionsChecked(questionCheckboxes);
                if (allChecked) {
                    // If all questions are checked, check the quiz checkbox.
                    quizCheckbox.checked = true;
                }
            } else {
                // If the question is unchecked, uncheck the quiz checkbox.
                questionEntry.classList.remove("question_selected");
                quizCheckbox.checked = false;
            }
        });
    });
}

/**
 * Adds an event listener to the question entries.
 * If a question entry is clicked, the checkbox is checked.
 * @param {number} quizId - The ID of the quiz, used to identify the checkboxes.
 */
function addQuestionEntryListeners(quizId) {
    let questionEntries = document.querySelectorAll(".question_entry_" + quizId);
    questionEntries.forEach((questionEntry) => {
        questionEntry.addEventListener("click", () => {
            let questionCheckbox = questionEntry.querySelector(".question_checkbox");
            questionCheckbox.checked = !questionCheckbox.checked;
            questionCheckbox.dispatchEvent(new Event("change"));
        });
    });
}

/**
 * Checks if all questions are checked.
 * @param {NodeList} questions
 * @returns {bool} - True if all questions are checked, false otherwise.
 */
function areAllQuestionsChecked(questions) {
    //Convert the NodeList to an array in order to use every function.
    return Array.from(questions).every((question) => question.checked); // Returns true only if all are checked
}
