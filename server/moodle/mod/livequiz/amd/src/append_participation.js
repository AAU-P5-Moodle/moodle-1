import {append_participation} from "./repository";

/**
 * Participation module for Live Quiz.
 *
 * @module     mod_livequiz/participation
 */

export const init = async (quizid,studentid) => {
    const takeQuizButton = document.getElementById("takeQuizBtn");
    takeQuizButton.addEventListener("click", function () {
        // Runs when buttong for taking the quiz is clicked.
        console.log(append_participation(quizid,studentid));
    });
};

