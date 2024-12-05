import {deleteQuestion} from "./repository";
import {rerenderTakeQuizButton} from "./helper";

let takeQuizUrl = "";

/**
 * Adds click-event listeners to the buttons for deleting questions.
 *
 * @param quizId
 * @param lecturerId
 * @param url
 * @returns {Promise<void>}
 */

export const init = async(quizId, lecturerId, url) => {
    // Set global variable holding the url to quiz attempt page.
    // Used for calling rerenderTakeQuizButton when the last question is deleted.
    takeQuizUrl = url;
    addDeleteQuestionListeners(quizId, lecturerId);
};

/**
 * Helper function for adding click-event listeners to delete buttons.
 *
 * @param {int} quizId
 * @param {int} lecturerId
 * @returns {void}
 */
export function addDeleteQuestionListeners(quizId, lecturerId) {
    let questionList = document.getElementById("saved_questions_list");
    let deleteQuestionElements = questionList.querySelectorAll(".delete-question");

    deleteQuestionElements.forEach((element) => {
        element.addEventListener("click", () => {
            let listItem = element.closest("li"); // Get the list item.
            let questionId = parseInt(element.dataset.id, 10);
            if (confirm("Are you sure you want to delete this question?")) {
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
                            throw("Cannot delete question, since it already has participations");
                        }
                    }).catch((error) => {
                        alert(error);
                    });
                }
            });
  });
}
