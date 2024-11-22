import Templates from "core/templates";
import { exception as displayException } from "core/notification";
import { delete_question } from "./repository";

export const init = async (quizid, lecturerid) => {
    let question_list = document.getElementById("saved_questions_list");
    let list_items = question_list.querySelectorAll("li");

    list_items.forEach((item) => {
        item.addEventListener("click", () => {
            console.log("Delete question");
            let questionid = item.id;
            questionid = parseInt(questionid.replace("question_list_", ""));
            console.log(questionid);
            delete_question(questionid, lecturerid, quizid);
            item.remove();
        });
    });
};