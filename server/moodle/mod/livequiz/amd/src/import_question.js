import Templates from "core/templates";
import {add_discard_question_button_listener, rerender_saved_questions_list} from "./edit_question_helper";
import {add_edit_question_listeners} from "./edit_question";
import {add_delete_question_listeners} from "./delete_question";
import {displayException} from "core/notification";
import {external_reuse_questions} from "./repository";
import {rerender_take_quiz_button} from "./take_quiz";

/**
 * Adds an event listener to the "Import Question" button.
 * When the button is clicked, it renders the import question menu popup.
 *
 * @param {number} quizid - The ID of the quiz.
 * @param {number} lecturerid - The ID of the lecturer.
 * @param {string} url - The URL to the quiz attempt page.
 * @returns {Promise<void>} A promise that resolves when the initialization is complete.
 */
export const init = async (quizid, lecturerid, url) => {
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
 * @returns {void}
 */
function render_import_question_menu_popup(quizid, lecturerid, url) {
    // This will call the function to load and render our template.
    Templates.renderForPromise("mod_livequiz/import_question_popup")

        // It returns a promise that needs to be resoved.
        .then(({ html, js }) => {
            // Here we have compiled template.
            Templates.appendNodeContents(".main-container", html, js);
            add_import_question_button_listener(quizid, lecturerid, url);
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
 * @param {string} url - THE URL of the quiz page.
 */
function add_import_question_button_listener(quizid, lecturerid, url) {
    let save_question_button = document.querySelector(".save_button");
    save_question_button.addEventListener("click", importQuestions(quizid, url, lecturerid));
}

/**
 * Imports questions into a quiz.
 *
 * @param {number} quizid - The ID of the quiz.
 * @param {string} url - The URL of the quiz page.
 * @param {number} lecturerid - The ID of the lecturer.
 * @returns {Promise<void>} A promise that resolves when the questions are imported.
 */
async function importQuestions(quizid, url, lecturerid){
    let quiz_url = url;
    const importQuestionBtn = document.getElementById("importQuestionBtn");
    let questionids = get_checked_questions();

    importQuestionBtn.addEventListener("click", async() => {
        try {
            await external_reuse_questions(quizid, questionids).then((questions) => {
                let update_event_listeners = () => {
                    add_edit_question_listeners(quizid, lecturerid);
                    add_delete_question_listeners(quizid, lecturerid);
                };
                rerender_saved_questions_list(questions, update_event_listeners); //Re-render saved questions list
                rerender_take_quiz_button(quiz_url, true); //Re-render take quiz button
            });
        } catch (error) {
            window.console.error("Error in import of questions");
        }
    });
}

/**
 * Retrieves the values of all checked questions from the lecturer's question list.
 *
 * @returns {Array<number>} An array containing the values of the checked questions.
 */
function get_checked_questions() {
    let checkedquestions = [];
    let questions_div = document.querySelector(".all_questions_for_lecturer_div");

    // Loop through all questions and add the value of the checked questions to the array.
    for (let question of questions_div.children) {
        let checkbox = question.querySelector('input[type="checkbox"]')
        if (checkbox.checked){
            checkedquestions.push(parseInt(checkbox.value));
        }
    };
    return checkedquestions; // Returns the checked questions.
};