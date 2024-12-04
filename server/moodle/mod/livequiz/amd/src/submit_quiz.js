import {submit_quiz} from "./repository";

// Setup eventlistener for inserting participation and answer choices upon submitting quiz.
export const init = async(quizid, studentid, resultsurl) => {
    const submitQuizButton = document.getElementById("submit_quiz_button");
    submitQuizButton.addEventListener("click", async function () {
        if(submit_quiz_confirm()){
            try {
                // Insert participation and the answers given in the quiz.
                await submit_quiz(quizid, studentid);
                window.location.href = resultsurl;
            } catch (error) {
                window.console.error("Error in submit_quiz", error);
            }
        }
    });
};


function submit_quiz_confirm() {
    if (confirm("Are you sure you want to submit the quiz?")) {
        return true;
    } else {
        return false;
    }
}