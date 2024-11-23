import Templates from "core/templates";
import { exception as displayException } from "core/notification";
import { save_question } from "./repository";
import {add_answer_button_event_listener, add_discard_question_button_listener} from "./edit_question_helper";

export const init = async (quizid, lecturerid) => {
    let question_list = document.getElementById("saved_questions_list");
    let edit_question_elements = question_list.querySelectorAll(".edit-question");
    edit_question_elements.forEach((element) => {
        let questionid = element.dataset.id;
        element.addEventListener("click", () => {
            render_edit_question_menu_popup(quizid, lecturerid, questionid);
        });
    });
};


function render_edit_question_menu_popup(quizid, lecturerid, questionid) {
    // This will call the function to load and render our template.
    Templates.renderForPromise("mod_livequiz/question_menu_popup")

        // It returns a promise that needs to be resolved.
        .then(({ html, js }) => {
            // Here we have the compiled template.
            Templates.appendNodeContents(".main-container", html, js);
            add_answer_button_event_listener();
            add_save_question_button_listener(quizid, lecturerid, questionid);
            add_discard_question_button_listener();
        })

        // Deal with this exception (Using core/notify exception function is recommended).
        .catch((error) => displayException(error));
}

function add_save_question_button_listener(quizid, lecturerid, questionid) {
    let save_question_button = document.querySelector(".save_button");
    save_question_button.addEventListener("click", () => {
        on_save_question_button_clicked(quizid, lecturerid, questionid);
    });
}

function on_save_question_button_clicked(quizid, lecturerid, questionid) {
    let question_input_title = document.getElementById("question_title_id");
    let question_indput_description = document.getElementById("question_description_id");
    let question_indput_explanation = document.getElementById("question_explanation_id");
    let questionTitle = question_input_title.value.trim();
    let questionDesription = question_indput_description.value.trim();
    let questionExplanation = question_indput_explanation.value.trim();

    if (!questionDesription) {
        alert("Please enter a question description.");
        return;
    }
    if(!questionTitle){
        questionTitle = "Question";
    }
    let answers = [];
    let answers_div = document.querySelector(".all_answers_for_question_div");
    for (let i = 0; i < answers_div.children.length; i++) {
        let answertext = answers_div.children[i]
            .querySelector(".answer_input")
            .value.trim();

        let iscorrect =
            answers_div.children[i].querySelector(".answer_checkbox").checked;
        iscorrect ? (iscorrect = 1) : (iscorrect = 0);

        answers.push({
            description: answertext,
            correct: iscorrect,
            explanation: "",
        });
    }

    let savedQuestion = {
        id: questionid,
        title: questionTitle,
        answers: answers,
        description: questionDesription,
        explanation: questionExplanation,
    };
    save_question(savedQuestion, lecturerid, quizid).then((questions) => {
        const contextsavedquestions = {
            questions: questions,
        };

        //Remove the saved questions list and take quiz button
        let questions_list = document.querySelector("#saved_questions_list");
        questions_list.remove();

        Templates.renderForPromise(
            "mod_livequiz/saved_questions_list",
            contextsavedquestions
        )
            // It returns a promise that needs to be resoved.
            .then(({ html, js }) => {
                // Here eventually I have my compiled template, and any javascript that it generated.
                // The templates object has append, prepend and replace functions.
                Templates.appendNodeContents("#saved-questions-container", html, js);
            })

            // Deal with this exception (Using core/notify exception function is recommended).
            .catch((error) => displayException(error));


    });
    let modal_div = document.querySelector(".Modal_div");
    modal_div.remove();
}





