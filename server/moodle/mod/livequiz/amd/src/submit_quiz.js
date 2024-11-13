import {insert_participation, insert_answer_choice} from "./repository";

export const init = async(quizid, studentid, answerids) => {
    window.console.log("submitting quiz");
    const submitQuizButton = document.getElementById("submitQuizBtn");
    submitQuizButton.addEventListener("click", async function () {
        try {
            window.console.log("starting to submit quiz after click");
            // Insert participation and wait for the participation ID.
            let participationid = await insert_participation(quizid, studentid);
            window.console.log("Inserted participation with ID: ", participationid);

            // Parse the answer IDs.
            window.console.log("answerids before: ",answerids);
            let answers = JSON.parse(answerids);
            window.console.log("answerids after: ",answers);

            // Insert each answer choice after participation is successfully created.
            for (let answerid of answers) {
                window.console.log("answerid: ",answerid);
                //try {
                //    await insert_answer_choice(studentid, answerid, participationid);
                //} catch (error) {
                //    window.console.error("Error in insert_answer_choice", error);
                //}
            }
        } catch (error) {
            window.console.error("Error in insert_participation", error);
        }
    });
};

