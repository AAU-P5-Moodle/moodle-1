import {insert_participation} from "./repository";

export const init = async(quizid, studentid) => {
    const submitQuizButton = document.getElementById("submitQuizBtn");
    submitQuizButton.addEventListener("click", async function () {
        try {
            window.console.log("insert_participation was successful: ", await insert_participation(quizid, studentid));
        } catch (error) {
            window.console.error("Error in insert_participation", error);
        }
    });
};

