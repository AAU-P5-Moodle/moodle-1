import {deleteQuestion} from "./repository";
import {rerenderTakeQuizButton} from "./edit_question_helper";

let takeQuizUrl = "";

export const init = async(quizId, lecturerId, url) => {
    takeQuizUrl = url; // Set url to quiz attempt page to global variable
    addDeleteQuestionListeners(quizId, lecturerId);
};

/**
 *
 * @param quizId
 * @param lecturerId
 */
export function addDeleteQuestionListeners(quizId, lecturerId) {
  let questionList = document.getElementById("saved_questions_list");
  let deleteQuestionElements = questionList.querySelectorAll(".delete-question");

  deleteQuestionElements.forEach((element) => {
    element.addEventListener("click", () => {
        let listItem = element.closest("li"); // Get the list item.
        let questionId = parseInt(element.dataset.id, 10);
        if (!confirm("Are you sure you want to delete this question?")) {
            return;
        } else {
            deleteQuestion(questionId, lecturerId, quizId)
                .then((response) => {
                    if (response.success) {
                        listItem.remove(); // Remove the question from the list.
                        element.remove(); // Remove the delete button.
                        let updatedListLength = questionList.querySelectorAll("li").length;
                        if (updatedListLength === 0) {
                            rerenderTakeQuizButton(takeQuizUrl, false);
                        }
                    } else {
                        alert("Cannot delete question: " + response.message);
                    }
                });
        }
    });
  });
}
