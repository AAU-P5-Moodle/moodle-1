import Templates from "core/templates";
import { exception as displayException } from "core/notification";
import { save_question, get_question } from "./repository";
import {
  add_answer_button_event_listener,
  create_answer_container,
  add_discard_question_button_listener,
} from "./helper";
import { rerender_saved_questions_list } from "./helper";
import { add_delete_question_listeners } from "./delete_question";

export const init = async (quizid, lecturerid) => {
  add_edit_question_listeners(quizid, lecturerid);
};

export function add_edit_question_listeners(quizid, lecturerid) {
  let question_list = document.getElementById("saved_questions_list");
  let edit_question_elements = question_list.querySelectorAll(".edit-question");
  edit_question_elements.forEach((element) => {
    let questionid = parseInt(element.dataset.id, 10);
    element.addEventListener("click", () => {
      render_edit_question_menu_popup(quizid, lecturerid, questionid);
    });
  });
}

function render_edit_question_menu_popup(quizid, lecturerid, questionid) {
  // This will call the function to load and render our template.
  Templates.renderForPromise("mod_livequiz/question_menu_popup")

    // It returns a promise that needs to be resolved.
    .then(({ html, js }) => {
      // Here we have the compiled template.
      Templates.appendNodeContents(".main-container", html, js);
      get_question(quizid, questionid).then((question) => {
        restore_question_data_in_popup(question);
      });
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
  let question_indput_description = document.getElementById(
    "question_description_id"
  );
  let question_indput_explanation = document.getElementById(
    "question_explanation_id"
  );
  let questionTitle = question_input_title.value.trim();
  let questionDesription = question_indput_description.value.trim();
  let questionExplanation = question_indput_explanation.value.trim();

  if (!questionDesription) {
    alert("Please enter a question description.");
    return;
  }
  if (!questionTitle) {
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
  
  //Specify the element we want to add event listeners to after saving questions
  let update_event_listeners = () => {
    add_edit_question_listeners(quizid, lecturerid);
    add_delete_question_listeners(quizid, lecturerid);
  }

  //Save question in DB, and rerender question list on front-end.
  save_question(savedQuestion, lecturerid, quizid).then((questions) => {rerender_saved_questions_list(questions, update_event_listeners)});
  
  //Remove edit question pop-up
  let modal_div = document.querySelector(".Modal_div");
  modal_div.remove();

}
function restore_question_data_in_popup(questiondata) {
  document.getElementById("question_title_id").value =
    questiondata.questiontitle;
  document.getElementById("question_description_id").value =
    questiondata.questiondescription;
  document.getElementById("question_explanation_id").value =
    questiondata.questionexplanation;
  let answers = questiondata.answers;
  for (let i = 0; i < answers.length; i++) {
    restore_answer_data_in_popup(answers[i]);
  }
  console.log("answers: ", answers);
}

function restore_answer_data_in_popup(answer) {
  let answer_container = create_answer_container(answer.answerid);
  answer_container.querySelector(".answer_input").value =
    answer.answerdescription;
  answer_container.querySelector(".answer_checkbox").checked =
    answer.answercorrect;
  let parent_element = document.querySelector(".all_answers_for_question_div");
  parent_element.appendChild(answer_container);
}
