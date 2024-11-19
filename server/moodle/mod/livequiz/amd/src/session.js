import { update_session } from "./repository";


// Update session with selected answers.
// @module     mod_livequiz/session.
export const init = async(quizid, questionid) => {
    // Select all answer options (radio buttons, checkboxes, and dropdowns).
    const answerOptions = document.getElementsByClassName(quizid);
    // Add a 'change' event listener to each option.
    answerOptions.forEach((option) => {
        option.addEventListener("change", function () {
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
            update_session(quizid, questionid, JSON.stringify(selectedAnswers));
            window.console.log("updated session");
        });
    });
};