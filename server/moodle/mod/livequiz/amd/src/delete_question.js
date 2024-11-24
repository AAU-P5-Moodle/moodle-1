import { delete_question } from "./repository";
import { rerender_take_quiz_button } from "./helper";

const take_quiz_url = "";

export const init = async (quizid, lecturerid, url) => {
  take_quiz_url = url; //Set url to quiz attempt page to global variable
  add_delete_question_listeners(quizid, lecturerid);
};

export function add_delete_question_listeners(quizid, lecturerid) {
  let question_list = document.getElementById("saved_questions_list");
  let list_items = question_list.querySelectorAll("li");

  list_items.forEach((item) => {
    item.addEventListener("click", () => {
      let questionid = item.id;
      questionid = parseInt(questionid.replace("question_list_", ""));
      delete_question(questionid, lecturerid, quizid);
      let edit_button = item.nextElementSibling; //The edit buttons is always a sibling of the question
      edit_button.remove();
      item.remove();

    });
  });
}
