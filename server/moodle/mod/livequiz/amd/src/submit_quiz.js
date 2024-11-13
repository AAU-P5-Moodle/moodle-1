import {insert_participation} from "./repository";

export const init = async(quizid, studentid) => {
    const submitQuizButton = document.getElementById("submitQuizBtn");
    submitQuizButton.addEventListener("click", function () {
        try {
            // Insert participation and wait for the participation ID.
            let participationid = insert_participation(quizid, studentid);
            window.console.log("Inserted participation with ID: ", participationid);
        } catch (error) {
            window.console.error("Error in insert_participation", error);
        }
    });
};
