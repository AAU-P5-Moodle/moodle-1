import {submitQuiz} from "./repository";

/**
 * Setup event listener for inserting participation and answer choices upon submitting quiz.
 *
 * @param quizId
 * @param studentId
 * @param resultsUrl
 * @returns {Promise<void>}
 */
export const init = async(quizId, studentId, resultsUrl) => {
    const submitQuizButton = document.getElementById("submit_quiz_button");
    submitQuizButton.addEventListener("click", async function() {
        if (submitQuizConfirm()) {
            try {
                // Insert participation and the answers given in the quiz.
                await submitQuiz(quizId, studentId);
                window.location.href = resultsUrl;
            } catch (error) {
                window.console.error("Error in submit_quiz", error);
            }
        }
    });
};

/**
 * Launch confirmation dialogue for submitting a quiz attempt.
 *
 * @returns {boolean}
 */
function submitQuizConfirm() {
    return confirm("Are you sure you want to submit the quiz?");
}