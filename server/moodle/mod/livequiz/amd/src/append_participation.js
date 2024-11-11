import {append_participation} from "./repository";

export const init = async(quizid, studentid) => {
    const takeQuizButton = document.getElementById("takeQuizBtn");
    takeQuizButton.addEventListener("click", async function () {
        window.console.log("quizid: ", quizid);// For debugging.
        window.console.log("studentid: ", studentid);// For debugging.
        try {
            window.console.log("result of appending: ", await append_participation(quizid, studentid));
        } catch (error) {
            window.console.error("Error in append_participation", error);
        }
    });
};

