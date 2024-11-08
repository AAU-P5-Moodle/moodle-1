import { append_participation } from "./repository";

/**
 * Participation module for Live Quiz.
 *
 * @module     mod_livequiz/participation
 */

export const init = async (quizid) => {
    window.console.log("Participation module for quiz ", await append_participation(quizid));
};