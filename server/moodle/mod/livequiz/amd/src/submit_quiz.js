import {submit_quiz} from "./repository";

// Setup eventlistener for inserting participation and answer choices upon submitting quiz.
export const init = async(quizid, studentid, resultsurl) => {
    const submitQuizButton = document.getElementById("submitQuizBtn");
    submitQuizButton.addEventListener("click", async function () {
        try {
            // Insert participation and the answers given in the quiz.
            await submit_quiz(quizid, studentid);
            window.location.href = resultsurl;
        } catch (error) {
            window.console.error("Error in submit_quiz", error);
        }
    });
};
