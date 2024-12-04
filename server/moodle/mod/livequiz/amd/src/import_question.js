import Templates from "core/templates";
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
async function renderImportQuestionMenuPopup(quizId, lecturerId, url) {
    // This will call the function to load and render our template.
    Templates.renderForPromise("mod_livequiz/import_question_popup", {}, "boost")
        // It returns a promise that needs to be resolved.
        .then(async({html, js}) => {
            // Here we have compiled template.
            Templates.appendNodeContents(".main-container", html, js);
            await importQuestions(quizId, url, lecturerId);
            addCancelEditButtonListener("import");
            addOldQuestionsToPopup(lecturerId, quizId);
        })
        .catch((error) => window.console.log(error)); // Deal with this exception (Using core/notify exception function is recommended).
}

/**
 * Adds old questions to the import question popup.
 *
 * @param {number} lecturerId - The ID of the lecturer.
 * @param {number} quizId - The ID of the quiz.
 * @returns {void}
 */
function addOldQuestionsToPopup(lecturerId, quizId) {
    getLecturerQuiz(lecturerId).then((oldQuizzes) => {
        oldQuizzes = oldQuizzes.filter(currentQuiz => currentQuiz.quizid !== quizId);
        let oldQuizzesContainer = document.querySelector(".oldQuizzes");
        if (oldQuizzes.length === 0) {
            let noQuestions = document.createElement("p");
            noQuestions.textContent = "No questions available.";
            oldQuizzesContainer.appendChild(noQuestions);
            return;
        }
        oldQuizzes.forEach((quiz) => { // Loop through all quizzes.
            if (quiz.questions.length > 0) {
                let questionCheckboxes = [];
                let quizDiv = document.createElement('div');
                // Create quiz checkbox.
                let quizCheckbox = document.createElement('input');
                quizCheckbox.type = "checkbox";
                quizCheckbox.value = quiz.quizid;
                quizCheckbox.id = quiz.quizid;
                quizCheckbox.style.marginRight = "5px"; // Add margin so the text is not too close to the checkbox.
                quizCheckbox.name = quiz.quiztitle;
                // Create quiz Label.
                let quizLabel = document.createElement('label');
                quizLabel.htmlFor = `quiz_${quiz.quizid}`;
                quizLabel.textContent = quiz.quiztitle;
                quizLabel.style.fontWeight = "bold"; // Make the quiz title bold.
                quizDiv.class = "oldquiz"; // Might be used for styling.

                // Append the checkbox and label to the div.
                quizDiv.appendChild(quizCheckbox);
                quizDiv.appendChild(quizLabel);
                // Set the border style
                quizDiv.style.border = "2px solid black";
                // Create container for questions.
                let questionsDiv = document.createElement("div");
                questionsDiv.style.marginBottom = "20px";
                questionsDiv.style.marginLeft = "20px"; // Add margin to the left so the questions are indented.
                questionsDiv.id = "questionsdiv";
                // Loop through each question and add it to the container.
                quiz.questions.forEach((question) => {
                    // Create question checkbox.
                    let questionDiv = document.createElement('div');
                    let questionCheckbox = document.createElement('input');
                    questionCheckbox.type = "checkbox";
                    questionCheckbox.value = `question_${question.questionid}`;
                    questionCheckbox.style.marginRight = "5px"; // Add margin so the text is not too close to the checkbox.
                    questionCheckbox.id = question.questionid;
                    questionCheckbox.name = question.questiontitle;
                    questionCheckboxes.push(questionCheckbox);
                    // Create question Label.
                    let questionLabel = document.createElement('label');
                    questionLabel.htmlFor = `question_${question.questionid}`;
                    questionLabel.textContent = question.questiontitle;

                    questionDiv.appendChild(questionCheckbox);
                    questionDiv.appendChild(questionLabel);
                    questionsDiv.appendChild(questionDiv);
                });
                addQuizCheckboxListener(quizCheckbox, questionCheckboxes);
                addQuestionCheckboxListener(quizCheckbox, questionCheckboxes);
                quizDiv.appendChild(questionsDiv);
                oldQuizzesContainer.appendChild(quizDiv);
            }
        });
    })
    .catch((error) => window.console.log(error));
}

/**
 * Imports questions into a quiz.
 *
 * @param {number} quizId - The ID of the quiz.
 * @param {string} url - The URL of the quiz page.
 * @param {number} lecturerId - The ID of the lecturer.
 * @returns {Promise<void>} A promise that resolves when the questions are imported.
 */
async function importQuestions(quizId, url, lecturerId) {
    let quizUrl = url;
    const importQuestionBtn = document.querySelector(".import_btn");

    importQuestionBtn.addEventListener("click", async() => {
        try {
            let questionIds = getCheckedQuestions();
            if (questionIds.length === 0) {
                alert("No questions selected. Pleas choose at least one question to import.")
                return;
            }
            callReuseQuestions(quizId, questionIds, lecturerId, quizUrl);
        } catch (error) {
            window.console.error("Error in import of questions");
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
        .catch((error) => window.console.log(error));
    let modalDiv = document.querySelector(".Modal_div");
    modalDiv.remove();
}

/**
 * Retrieves the values of all checked questions from the lecturer's question list.
 *
 * @returns {Array<number>} An array containing the ids of the checked questions.
 */
function getCheckedQuestions() {
    let checkedQuestions = [];
    let questionsDiv = document.querySelector(".oldQuizzes");

    // Loop through all quizzes and get the checked questions.
    for (let quizDiv of questionsDiv.children) { // Loop through all quizzes.
        for (let content of quizDiv.children) { // Loop through all content of the quiz.
            if (content.tagName === "DIV") { // Only look in div elements
                for (let questionDiv of content.children) { // Loop through all questions.
                    for (let children of questionDiv.children) { // Loop through all children of the question.
                        if (children.tagName === "INPUT") { // Only look in input elements.
                            let checkbox = children;
                            if (checkbox.checked) { // If the checkbox is checked, add the id to the array.
                                checkedQuestions.push(parseInt(checkbox.id));
                            }
                        }
                    }
                }
            }
        }
    }
    return checkedQuestions; // Returns the checked questions.
}

/**
 * Adds an event listener to the quiz checkboxes.
 *
 * @param checkbox - The checkbox to add the event listener to.
 * @param questionCheckboxes - The question checkboxes that are manipulated when event is triggered.
 * @returns {void}
 */
function addQuizCheckboxListener(checkbox, questionCheckboxes) {
    checkbox.addEventListener("change", () => {
        questionCheckboxes.forEach((questionCheckbox) => {
            questionCheckbox.checked = checkbox.checked; // Set all questions to checked if the quiz is checked.
        });
    });
}

/**
 * Adds an event listener to the question checkboxes.
 *
 * @param checkbox - The checkbox that is manipulated when all questions are checked.
 * @param questionCheckboxes - The question checkboxes to add the event listener to.
 * @returns {void}
 */
function addQuestionCheckboxListener(checkbox, questionCheckboxes) {
    questionCheckboxes.forEach((questionCheckbox) => {
        questionCheckbox.addEventListener("change", () => {
            if (questionCheckbox.checked) { // If the question is checked, check if all questions are checked.
                let checkboxesSame = checkQuestionsChecked(questionCheckboxes);
                if (checkboxesSame) { // If all questions are checked, check the quiz checkbox.
                    checkbox.checked = questionCheckbox.checked;
                }
            } else { // If the question is unchecked, uncheck the quiz checkbox.
                checkbox.checked = questionCheckbox.checked;
            }
        });
    });
}

/**
 * Checks if all questions are checked.
 *
 * @param questions
 * @returns {bool} - True if all questions are checked, false otherwise.
 */
function checkQuestionsChecked(questions) {
    return questions.every((question) => question.checked); // Returns true only if all are checked
}