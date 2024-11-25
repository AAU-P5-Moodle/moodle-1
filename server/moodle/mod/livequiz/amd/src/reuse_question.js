import {external_reuse_questions} from ".repository.js";
import { rerender_saved_questions_list } from "./edit_question_helper";
import { add_delete_question_listeners } from "./delete_question";
import { add_edit_question_listeners } from "./edit_question";


/**
 * Imports questions into a quiz.
 *
 * @param {number} quizid - The ID of the quiz.
 * @param {string} url - The URL of the quiz page.
 * @param {number} lecturerid - The ID of the lecturer.
 * @returns {Promise<void>} A promise that resolves when the questions are imported.
 */
export const importQuestions = async(quizid, url, lecturerid) => {
    quiz_url = url; //Set url to quiz attempt page to global variable
    const importQuestionBtn = document.getElementById("importQuestionBtn");
    $questionids = get_checked_questions();
    
    importQuestionBtn.addEventListener("click", async() => {
        try {
            await external_reuse_questions(quizid, questionids).then((questions) => {
                let update_event_listeners = () => {
                    add_edit_question_listeners(quizid, lecturerid);
                    add_delete_question_listeners(quizid, lecturerid);
                }
                rerender_saved_questions_list(questions, update_event_listeners); //Re-render saved questions list
                rerender_take_quiz_button(quiz_url, true); //Re-render take quiz button       
            });
        } catch (error) {
            window.console.error("Error in import of questions");
        }
    });
};

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