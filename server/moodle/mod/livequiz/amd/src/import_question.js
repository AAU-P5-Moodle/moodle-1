import Templates from "core/templates";
import {add_discard_question_button_listener, rerender_saved_questions_list} from "./edit_question_helper";
import {add_edit_question_listeners} from "./edit_question";
import {add_delete_question_listeners} from "./delete_question";
import {displayException} from "core/notification";
import {external_reuse_questions, get_lecturer_questions} from "./repository";
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
            add_discard_question_button_listener();
            add_old_questions_to_popup(lecturerid);
        })

        // Deal with this exception (Using core/notify exception function is recommended).
        .catch((error) => console.error(error));
}

/**
 * Adds old questions to the import question popup.
 * @param {number} lecturerid - The ID of the lecturer.
 */
function add_old_questions_to_popup(lecturerid) {
    get_lecturer_questions(lecturerid).then((oldquestions) => {
        oldquestions.forEach((question) => {
            let question_div = document.createElement("div");
            question_div.innerHTML = `
                <input type="checkbox" value="${question.questionid}" id="question_${question.questionid} ">
                <label for="question_${question.questionid}">${question.questiontitle}</label>
                `;
            document.querySelector(".oldQuestions").appendChild(question_div);
        });
    }).catch((error) => console.error(error));
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
    const importQuestionBtn = document.querySelector(".import_btn");

    importQuestionBtn.addEventListener("click", async() => {
        try {
            let questionids = get_checked_questions();
            call_reuse_questions(quizid, questionids, lecturerid, quiz_url);
        } catch (error) {
            window.console.error("Error in import of questions");
            displayException(error);
        }
    });
}

/**
 * Calls the external function to reuse questions.
 * @param {number} quizid - The ID of the quiz.
 * @param {number} questionids - The IDs of the questions to reuse.
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
        rerender_take_quiz_button(quiz_url, true); // Re-render take quiz button.
    }). catch((error) => displayException(error));
    let modal_div = document.querySelector(".Modal_div");
    modal_div.remove();
}

/**
 * Retrieves the values of all checked questions from the lecturer's question list.
 *
 * @returns {Array<number>} An array containing the values of the checked questions.
 */
function get_checked_questions() {
    let checkedquestions = [];
    let questions_div = document.querySelector(".oldQuestions");

    // Loop through all questions and add the value of the checked questions to the array.
    for (let question of questions_div.children) {
        let checkbox = question.querySelector('input[type="checkbox"]');
        if (checkbox.checked) {
            checkedquestions.push(parseInt(checkbox.value));
        }
    }
    return checkedquestions; // Returns the checked questions.
}