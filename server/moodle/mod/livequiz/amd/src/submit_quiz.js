import {insert_participation, insert_answer_choice} from "./repository";

export const init = async(quizid, studentid, answerids) => {
    window.console.log("submitting quiz");
    const submitQuizButton = document.getElementById("submitQuizBtn");
    submitQuizButton.addEventListener("click", async function () {
        try {
            // Insert participation and wait for the participation ID.
            let participationid = await insert_participation(quizid, studentid);
            window.console.log("Inserted participation with ID: ", participationid);

            let answers = JSON.parse(answerids);

            // Insert each answer choice after participation is successfully created.
            for (let answerid of answers) {
                try {
                    await insert_answer_choice(studentid, answerid, participationid);
                } catch (error) {
                    window.console.error("Error in insert_answer_choice", error);
                }
            }
        } catch (error) {
            window.console.error("Error in insert_participation", error);
        }
    });
};

