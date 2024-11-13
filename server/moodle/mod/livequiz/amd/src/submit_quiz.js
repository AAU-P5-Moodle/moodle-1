import {insert_participation, insert_answer_choices} from "./repository";

export const init = async(quizid, studentid) => {
    window.console.log("submitting quiz with");
    const submitQuizButton = document.getElementById("submitQuizBtn");
    submitQuizButton.addEventListener("click", function () {
        try {
            window.console.log("starting to submit quiz after click");
            // Insert participation and wait for the participation ID.
            let participationid = insert_participation(quizid, studentid);
            window.console.log("Inserted participation with ID: ", participationid);

            window.console.log("Inserting answers");
            insert_answer_choices(studentid, participationid, quizid);
            window.console.log("Done with answers");

            // Insert each answer choice after participation is successfully created.
            /*for (let answerid of answers) {
                window.console.log("answerid: ",answerid);
                //try {
                //    await insert_answer_choice(studentid, answerid, participationid);
                //} catch (error) {
                //    window.console.error("Error in insert_answer_choice", error);
                //}
            }*/
        } catch (error) {
            window.console.error("Error in insert_participation", error);
        }
    });
};

