import Templates from "core/templates";
import { exception as displayException } from "core/notification";
import { delete_question } from "./repository";

export const init = async (quizid, lecturerid) => {
    let add_question_button = document.getElementById("id_buttonaddquestion");
    add_question_button.addEventListener("click", () => {
        render_question_menu_popup(quizid, lecturerid);
    });
};