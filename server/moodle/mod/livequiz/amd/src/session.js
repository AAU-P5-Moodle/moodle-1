import {updateSession} from "./repository";

/**
 * Update session with selected answers.
 *
 * @param quizId
 * @param questionId
 * @returns {Promise<void>}
 */
export const init = async(quizId, questionId) => {
    // Select all answer options (radio buttons, checkboxes, and dropdowns).
    const answerOptions = document.getElementsByClassName(quizId);
    // Add a 'change' event listener to each option.
    answerOptions.forEach((option) => {
        option.addEventListener("change", function() {
            // Runs each time an option is selected.
            const selectedAnswers = [];
            // Get all selected answers.
            Array.from(answerOptions).forEach((input) => {
                if (
                    input.checked ||
                    (input.type === "radio" && input.checked) ||
                    (input.type === "checkbox" && input.checked)
                ) {
                    selectedAnswers.push(input.value);
                }
            });
            updateSession(quizId, questionId, JSON.stringify(selectedAnswers));
            window.console.log("updated session");
        });
    });
};