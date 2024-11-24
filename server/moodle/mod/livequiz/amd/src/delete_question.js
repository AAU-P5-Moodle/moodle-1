import { delete_question } from "./repository";

export const init = async (quizid, lecturerid) => {
    add_delete_question_listeners(quizid, lecturerid);
};

export function add_delete_question_listeners(quizid, lecturerid){
    let question_list = document.getElementById("saved_questions_list");
    let delete_question_elements = question_list.querySelectorAll(".delete-question");

    delete_question_elements.forEach((element) => {
        element.addEventListener("click", () => {
            let list_item = element.closest("li"); // Get the list item.
            let questionid = parseInt(element.dataset.id, 10);
            if(!confirm("Are you sure you want to delete this question?")){
                return;
            }
            else{
                delete_question(questionid, lecturerid, quizid);
                list_item.remove(); // Remove the question from the list.
                element.remove(); // Remove the delete button.
            }
        });
    });
}

