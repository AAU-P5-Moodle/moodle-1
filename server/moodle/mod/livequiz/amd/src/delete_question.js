import { delete_question } from "./repository";

export const init = async (quizid, lecturerid) => {
    add_delete_question_listeners(quizid, lecturerid);
};

export function add_delete_question_listeners(quizid, lecturerid){
    let question_list = document.getElementById("saved_questions_list");
    let list_items = question_list.querySelectorAll("li");

    list_items.forEach((item) => {
        item.addEventListener("click", () => {
            let questionid = item.id;
            questionid = parseInt(questionid.replace("question_list_", ""));
            delete_question(questionid, lecturerid, quizid);
            item.remove();
        });
    });
}