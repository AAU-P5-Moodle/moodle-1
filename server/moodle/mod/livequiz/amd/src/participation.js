// File: mod/livequiz/amd/src/participation.js

import { test_ajax } from "./repository";

/**
 * Participation module for Live Quiz.
 *
 * @module     mod_livequiz/participation
 */

export const init = async (quizid) => {
    window.console.log("Participation module for quiz ", await test_ajax({ quizid: 5 }));
};

/*
define(["jquery", "core/ajax", "core/str"], function (Ajax, Str) {
    return {
        init: function (quizid) {
            console.log("Participation module initialized for quiz ", quizid);
            var participateButton = document.getElementById("takeQuizBtn");
            if (participateButton) {
                participateButton.addEventListener("click", function (e) {
                    e.preventDefault();

                    // Make an AJAX request.
                    var requests = Ajax.call([
                        {
                            methodname: "mod_livequiz_append_participation",
                            args: { quizid: quizid },
                        },
                    ]);

                    requests[0]
                        .done(function () {
                            // Handle success.
                            console.log("AJAX request successful.");
                            Str.get_string("participation_recorded", "mod_livequiz").then(function (string) {
                                alert(string);
                            });
                        })
                        .fail(function () {
                            console.log("AJAX request failed.");
                            // Handle error.
                            Str.get_string("participation_error", "mod_livequiz").then(function (string) {
                                alert(string);
                            });
                        });
                });
            } else {
                console.log("Participate button not found.");
            }
        },
    };
});
*/
