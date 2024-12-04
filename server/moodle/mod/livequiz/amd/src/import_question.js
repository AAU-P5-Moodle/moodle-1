import Templates from "core/templates";
import {add_cancel_edit_button_listener, rerender_saved_questions_list} from "./edit_question_helper";
import {add_edit_question_listeners} from "./edit_question";
import {add_delete_question_listeners} from "./delete_question";
import {displayException} from "core/notification";
import {external_reuse_questions, get_lecturer_quiz} from "./repository";
import {rerender_take_quiz_button} from "./edit_question_helper";

/**
 * Adds an event listener to the "Import Question" button.
 * When the button is clicked, it renders the import question menu popup.
 *
 * @param {number} quizid - The ID of the quiz.
 * @param {number} lecturerid - The ID of the lecturer.
 * @param {string} url - The URL to the quiz attempt page.
 * @returns {Promise<void>} A promise that resolves when the initialization is complete.
 */
export const init = async(quizid, lecturerid, url) => {
    let import_question_button = document.getElementById("id_buttonimportquestion");
    import_question_button.addEventListener("click", () => {
        render_import_question_menu_popup(quizid, lecturerid, url);
    });
};


/**
 * Renders the import question menu popup for a live quiz.
 *
 * This function loads and renders the import question menu popup template, appends it to the main container,
 * Sets up event listeners for importing questions and cancelling the import.
 *
 * @param {number} quizid - The ID of the quiz.
 * @param {number} lecturerid - The ID of the lecturer.
 * @param {string} url - The URL to the quiz attempt page.
 * @returns {void} - Nothing.
 */
async function render_import_question_menu_popup(quizid, lecturerid, url) {
    // This will call the function to load and render our template.
    Templates.renderForPromise("mod_livequiz/import_question_popup")
        // It returns a promise that needs to be resolved.
        .then(async({html, js}) => {
            // Here we have compiled template.
            Templates.appendNodeContents(".main-container", html, js);
            await importQuestions(quizid, url, lecturerid);
            add_cancel_edit_button_listener("import");
            add_old_questions_to_popup(lecturerid, quizid);
        })

        // Deal with this exception (Using core/notify exception function is recommended).
        .catch((error) => displayException(error));
}

/**
 * Adds old questions to the import question popup.
 * @param {number} lecturerid - The ID of the lecturer.
 * @param {number} quizid - The ID of the quiz.
 */
function add_old_questions_to_popup(lecturerid, quizid) {
    get_lecturer_quiz(lecturerid).then((oldquizzes) => {
        oldquizzes = oldquizzes.filter(currentquiz => currentquiz.quizid !== quizid);
        let oldQuizzesContainer = document.querySelector(".old_quizzes");
        if (oldquizzes.length === 0) {
            let noQuestions = document.createElement("p");
            noQuestions.textContent = "No questions available.";
            oldQuizzesContainer.appendChild(noQuestions);
            return;
        }
        oldquizzes.forEach((quiz) => { // Loop through all quizzes.
            if (quiz.questions.length > 0) {
                let question_checkboxes = [];
                let quiz_div = document.createElement('div');
                //Create quiz checkbox.
                let quiz_checkbox = document.createElement('input');
                quiz_checkbox.type = "checkbox";
                quiz_checkbox.value = quiz.quizid;
                quiz_checkbox.id = quiz.quizid;
                quiz_checkbox.style.marginRight = "5px"; // Add margin so the text is not too close to the checkbox.
                quiz_checkbox.name = quiz.quiztitle;
                // Create quiz Label.
                let quiz_label = document.createElement('label');
                quiz_label.htmlFor = `quiz_${quiz.quizid}`;
                quiz_label.textContent = quiz.quiztitle;
                quiz_label.style.fontWeight = "bold"; // Make the quiz title bold.
                quiz_div.class = "oldquiz"; // Might be used for styling.

                // Append the checkbox and label to the div.
                quiz_div.appendChild(quiz_checkbox);
                quiz_div.appendChild(quiz_label);
                // Set the border style
                quiz_div.style.border = "2px solid black";
                // Create container for questions.
                let questions_div = document.createElement("div");
                questions_div.style.marginBottom = "20px";
                questions_div.style.marginLeft = "20px"; // Add margin to the left so the questions are indented.
                questions_div.id = "questionsdiv";
                // Loop through each question and add it to the container.
                quiz.questions.forEach((question) => {
                    //Create question checkbox.
                    let question_div = document.createElement('div');
                    let question_checkbox = document.createElement('input');
                    question_checkbox.type = "checkbox";
                    question_checkbox.value = `question_${question.questionid}`;
                    question_checkbox.style.marginRight = "5px"; // Add margin so the text is not too close to the checkbox.
                    question_checkbox.id = question.questionid;
                    question_checkbox.name = question.questiontitle;
                    question_checkboxes.push(question_checkbox);
                    // Create question Label.
                    let question_label = document.createElement('label');
                    question_label.htmlFor = `question_${question.questionid}`;
                    question_label.textContent = question.questiontitle;

                    question_div.appendChild(question_checkbox);
                    question_div.appendChild(question_label);
                    questions_div.appendChild(question_div);
                });
                add_quiz_checkbox_listener(quiz_checkbox, question_checkboxes);
                add_question_checkbox_listener(quiz_checkbox, question_checkboxes);
                quiz_div.appendChild(questions_div);
                oldQuizzesContainer.appendChild(quiz_div);
            }
        });
    }).catch((error) => console.log(error));
}

/**
 * Imports questions into a quiz.
 *
 * @param {number} quizid - The ID of the quiz.
 * @param {string} url - The URL of the quiz page.
 * @param {number} lecturerid - The ID of the lecturer.
 * @returns {Promise<void>} A promise that resolves when the questions are imported.
 */
async function importQuestions(quizid, url, lecturerid) {
    let quiz_url = url;
    const importQuestionBtn = document.querySelector(".import_question_button");

    importQuestionBtn.addEventListener("click", async() => {
        try {
            let questionids = get_checked_questions();
            if (questionids.length === 0) {
                alert("No questions selected. Pleas choose at least one question to import.")
                return;
            }
            call_reuse_questions(quizid, questionids, lecturerid, quiz_url);
        } catch (error) {
            window.console.error("Error in import of questions");
            console.log(error);
        }
    });
}

/**
 * Calls the external function to reuse questions.
 * @param {number} quizid - The ID of the quiz.
 * @param {array} questionids - The IDs of the questions to reuse.
 * @param {number} lecturerid - The ID of the lecturer.
 * @param {string} quiz_url - The URL of the quiz page.
 */
function call_reuse_questions(quizid, questionids, lecturerid, quiz_url) {
    external_reuse_questions(quizid, questionids, lecturerid).then((questions) => {
        let update_event_listeners = () => {
            add_edit_question_listeners(quizid, lecturerid);
            add_delete_question_listeners(quizid, lecturerid);
        };
        rerender_saved_questions_list(questions, update_event_listeners); // Re-render saved questions list.
        rerender_take_quiz_button(quiz_url, true); // Re-render take quiz button. Since at least one question was imported, hasquestions is true.
    }). catch((error) => console.log(error));
    let modal_div = document.querySelector(".modal_div");
    modal_div.remove();
}

/**
 * Retrieves the values of all checked questions from the lecturer's question list.
 *
 * @returns {Array<number>} An array containing the ids of the checked questions.
 */
function get_checked_questions() {
    let checkedquestions = [];
    let questions_div = document.querySelector(".old_quizzes");

    // Loop through all quizzes and get the checked questions.
    for (let quiz_div of questions_div.children) { // Loop through all quizzes.
        for (let content of quiz_div.children) { // Loop through all content of the quiz.
            if (content.tagName === "DIV") { // Only look in div elements
                for (let question_div of content.children) { // Loop through all questions.
                    for (let children of question_div.children) { // Loop through all children of the question.
                        if (children.tagName === "INPUT") { // Only look in input elements.
                            let checkbox = children;
                            if (checkbox.checked) { // If the checkbox is checked, add the id to the array.
                                checkedquestions.push(parseInt(checkbox.id));
                            }
                        }
                    }
                }
            }
        }
    }
    return checkedquestions; // Returns the checked questions.
}

/**
 * Adds an event listener to the quiz checkboxes.
 * @param checkbox - The checkbox to add the event listener to.
 * @param questioncheckboxes - The question checkboxes that are manipulated when event is triggered.
 */
function add_quiz_checkbox_listener(checkbox, questioncheckboxes){
    checkbox.addEventListener("change", () => {
        questioncheckboxes.forEach((questioncheckbox) => {
            questioncheckbox.checked = checkbox.checked; // Set all questions to checked if the quiz is checked.
        });
    });
}

/**
 * Adds an event listener to the question checkboxes.
 * @param checkbox - The checkbox that is manipulated when all questions are checked.
 * @param questioncheckboxes - The question checkboxes to add the event listener to.
 */
function add_question_checkbox_listener(checkbox, questioncheckboxes){
    questioncheckboxes.forEach((questioncheckbox) => {
        questioncheckbox.addEventListener("change", () => {
            if(questioncheckbox.checked) { // If the question is checked, check if all questions are checked.
                let checkboxes_same = false;
                checkboxes_same = check_questions_checked(questioncheckboxes);
                if (checkboxes_same) { // If all questions are checked, check the quiz checkbox.
                    checkbox.checked = questioncheckbox.checked;
                }
            } else { // If the question is unchecked, uncheck the quiz checkbox.
                checkbox.checked = questioncheckbox.checked;
            }
        });
    });
}

/**
 * Checks if all questions are checked.
 * @param questions
 * @returns {bool} - True if all questions are checked, false otherwise.
 */
function check_questions_checked(questions) {
    return questions.every((question) => question.checked); // Returns true only if all are checked
}