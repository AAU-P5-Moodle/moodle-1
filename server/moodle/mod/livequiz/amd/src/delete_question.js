import { delete_question } from "./repository";
import { rerender_take_quiz_button } from "./edit_question_helper";

let take_quiz_url = "";

export const init = async (quizid, lecturerid, url) => {
  take_quiz_url = url; //Set url to quiz attempt page to global variable
  add_delete_question_listeners(quizid, lecturerid);
};

export function add_delete_question_listeners(quizid, lecturerid) {
  let question_list = document.getElementById("saved_questions_list");
  let delete_question_elements = question_list.querySelectorAll(".delete-question");

  delete_question_elements.forEach((element) => {
    element.addEventListener("click", () => {
      let list_item = element.closest("li"); // Get the list item.
      let questionid = parseInt(element.dataset.id, 10);
            if (!confirm("Are you sure you want to delete this question?")) {
                return;
            } else {
                delete_question(questionid, lecturerid, quizid)
                    .then((response) => {
                        if (response.success) {
                            list_item.remove(); // Remove the question from the list.
                            element.remove(); // Remove the delete button.
                            let updated_list_length = question_list.querySelectorAll("li").length;
                            if (updated_list_length === 0) {
                                rerender_take_quiz_button(take_quiz_url, false);
                            }
                        } else {
                            throw("Cannot delete question, since it already has participations");
                        }
                    }).catch((error) => {
                        alert(error);
                    });
                }
            });
  });
}
