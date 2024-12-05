import Templates from "core/templates";
import { exception as displayException } from "core/notification";
import { add_cancel_edit_button_listener, rerender_saved_questions_list } from "./edit_question_helper";
import { add_edit_question_listeners } from "./edit_question";
import { add_delete_question_listeners } from "./delete_question";
import { external_reuse_questions, get_lecturer_quiz } from "./repository";
import { rerender_take_quiz_button } from "./edit_question_helper";

/**
 * Adds an event listener to the "Import Question" button.
 * When the button is clicked, it renders the import question menu popup.
 *
 * @param {number} quizId - The ID of the quiz.
 * @param {number} lecturerId - The ID of the lecturer.
 * @param {string} url - The URL to the quiz attempt page.
 * @returns {Promise<void>} A promise that resolves when the initialization is complete.
 */
export const init = async (quizId, lecturerId, url) => {
    let importQuestionButton = document.getElementById("id_buttonimportquestion");
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
    if (!document.querySelector(".Modal_div")) {
        Templates.renderForPromise("mod_livequiz/import_question_popup")
            // It returns a promise that needs to be resolved.
            .then(({ html, js }) => {
                // Here we have compiled template.
                Templates.appendNodeContents(".main-container", html, js);
                importQuestions(quizId, url, lecturerId);
                add_cancel_edit_button_listener("import");
                addOldQuestionsToPopup(lecturerId, quizId);
            })

            // Deal with this exception (Using core/notify exception function is recommended).
            .catch((error) => displayException(error));
    }
}

/**
 * Adds old questions to the import question popup.
 * @param {number} lecturerId - The ID of the lecturer.
 * @param {number} quizId - The ID of the quiz.
 */
function addOldQuestionsToPopup(lecturerId, quizId) {
    get_lecturer_quiz(lecturerId)
        .then((oldQuizzes) => {
            // Filter out the current quiz, so you can't import questions from the same quiz.
            oldQuizzes = oldQuizzes.filter((currentquiz) => currentquiz.quizid !== quizId);

            // Check how many questions are available.
            let oldQuizzesContainer = document.querySelector(".oldQuizzes");
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
                            Templates.appendNodeContents(".oldQuizzes", html, js);
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
 * @param {string} url - The URL of the quiz page.
 * @param {number} lecturerId - The ID of the lecturer.
 * @returns {Promise<void>} A promise that resolves when the questions are imported.
 */
function importQuestions(quizId, url, lecturerId) {
    let quizUrl = url;
    const importQuestionBtn = document.querySelector(".import_btn");

    importQuestionBtn.addEventListener("click", async () => {
        try {
            let questionIds = getCheckedQuestions();
            if (questionIds.length === 0) {
                alert("No questions selected. Please choose at least one question to import.");
                return;
            }
            call_reuse_questions(quizId, questionIds, lecturerId, quizUrl);
        } catch (error) {
            displayException(error);
        }
    });
}

/**
 * Calls the external function to reuse questions.
 * @param {number} quizId - The ID of the quiz.
 * @param {array} questionIds - The IDs of the questions to reuse.
 * @param {number} lecturerId - The ID of the lecturer.
 * @param {string} quizUrl - The URL of the quiz page.
 */
function call_reuse_questions(quizId, questionIds, lecturerId, quizUrl) {
    external_reuse_questions(quizId, questionIds, lecturerId)
        .then((questions) => {
            let update_event_listeners = () => {
                add_edit_question_listeners(quizId, lecturerId);
                add_delete_question_listeners(quizId, lecturerId);
            };
            rerender_saved_questions_list(questions, update_event_listeners); // Re-render saved questions list.
            rerender_take_quiz_button(quizUrl, true); // Re-render take quiz button.
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
