import { update_session } from "./repository";

/**
 * Update session with selected answers.
 * @module     mod_livequiz/session
 */
export const init = async (quizid, questionid) => {
  window.console.log("PLEASE CALL THIS");

  window.console.log("loaded DOM content");

  // Select all answer options (radio buttons, checkboxes, and dropdowns)
  const answerOptions = document.getElementsByClassName(quizid);

  window.console.log(answerOptions);

  // Add a 'change' event listener to each option
  answerOptions.forEach((option) => {
    option.addEventListener("change", function (event) {
      // Runs each time an option is selected
      const selectedAnswers = [];
      // Get all selected answers
      Array.from(answerOptions).forEach((input) => {
        if (
          input.checked ||
          (input.type === "radio" && input.checked) ||
          (input.type === "checkbox" && input.checked)
        ) {
          selectedAnswers.push(input.value);
        }
      });
    //KEPT FOR DEVELOPMENT
    window.console.log(selectedAnswers);
    update_session(questionid, selectedAnswers);
    });
  });

};
