// File: mod/livequiz/amd/src/participation.js

import { test_ajax } from "./repository";

/**
 * Participation module for Live Quiz.
 *
 * @module     mod_livequiz/participation
 */

export const init = async (quizid) => {
    window.console.log("Participation module for quiz ", await test_ajax(quizid));
};