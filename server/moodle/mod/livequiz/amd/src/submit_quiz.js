import {submitQuiz} from "./repository";

// Setup eventlistener for inserting participation and answer choices upon submitting quiz.
export const init = async(quizId, studentId, resultsUrl) => {
    const submitQuizButton = document.getElementById("submitQuizBtn");
    submitQuizButton.addEventListener("click", async function() {
        if(submitQuizConfirm()){
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


function submitQuizConfirm() {
    if (confirm("Are you sure you want to submit the quiz?")) {
        return true;
    } else {
        return false;
    }
}