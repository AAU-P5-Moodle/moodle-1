import {import_questions} from ".repository.js";
import { rerender_saved_questions_list } from "./edit_question_helper";
import { add_delete_question_listeners } from "./delete_question";
import { add_edit_question_listeners } from "./edit_question";
import { save_question } from "./repository";



// Eventlisener for importing(reuse) questions into an existing quiz.
export const importQuestions = async(quizid, questionids, url, lecturerid) => {
    take_quiz_url = url; //Set url to quiz attempt page to global variable
    const importQuestionBtn = document.getElementById("importQuestionBtn");
    
    importQuestionBtn.addEventListener("click", async() => {
        try {
            await import_questions(quizid, questionids).then((questions) => {
                let update_event_listeners = () => {
                    add_edit_question_listeners(quizid, lecturerid);
                    add_delete_question_listeners(quizid, lecturerid);
                }
                rerender_saved_questions_list(questions, update_event_listeners); //Re-render saved questions list
                rerender_take_quiz_button(take_quiz_url, true); //Re-render take quiz button       
            });
        } catch (error) {
            window.console.error("Error in import of questions");
        }
    });
};