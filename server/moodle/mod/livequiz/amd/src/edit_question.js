import Templates from "core/templates";
import { exception as displayException } from "core/notification";
import { saveQuestion, getQuestion} from "./repository";
import {
    addAnswerButtonEventListener,
    createAnswerContainer,
    addCancelEditButtonListener,
    validateSubmission} from "./helper";
import {addDeleteQuestionListeners} from "./delete_question";

export const init = async(quizId, lecturerId) => {
    addEditQuestionListeners(quizId, lecturerId);
};

/**
 *
 * @param quizId
 * @param lecturerId
 */
export function addEditQuestionListeners(quizId, lecturerId) {
    let questionList = document.getElementById("saved_questions_list");
    questionList.addEventListener("click", (event) => {
        let target = event.target;
        if (target.classList.contains("edit-question-btn") || target.classList.contains("question-title")) {
            let questionId = parseInt(target.dataset.id, 10);
            renderEditQuestionMenuPopup(quizId, lecturerId, questionId);
        }
    });
}

/**
 *
 * @param quizId
 * @param lecturerId
 * @param questionId
 */
function renderEditQuestionMenuPopup(quizId, lecturerId, questionId) {

if (!document.querySelector('.Modal_div')) {
    // This will call the function to load and render our template.
    Templates.renderForPromise("mod_livequiz/question_menu_popup")

        // It returns a promise that needs to be resolved.
        .then(({html, js}) => {
            // Here we have the compiled template.
            Templates.appendNodeContents(".main-container", html, js);
            getQuestion(quizId, questionId).then((question)=> {restoreQuestionDataInPopup(question);});
            addAnswerButtonEventListener();
            addSaveQuestionButtonListener(quizId, lecturerId, questionId);
            addCancelEditButtonListener("edit");
        })

      // Deal with this exception (Using core/notify exception function is recommended).
      .catch((error) => displayException(error));
  }
}

/**
 *
 * @param quizId
 * @param lecturerId
 * @param questionId
 */
function addSaveQuestionButtonListener(quizId, lecturerId, questionId) {
    let saveQuestionButton = document.querySelector(".save_button");
    saveQuestionButton.addEventListener("click", () => {
        onSaveQuestionButtonClicked(quizId, lecturerId, questionId);
    });
}


/**
 *
 * @param quizId
 * @param lecturerId
 * @param questionId
 */
function onSaveQuestionButtonClicked(quizId, lecturerId, questionId) {
    let questionInputTitle = document.getElementById("question_title_id");
    let questionInputDescription = document.getElementById("question_description_id");
    let questionInputExplanation = document.getElementById("question_explanation_id");
    let questionTitle = questionInputTitle.value.trim();
    let questionDescription = questionInputDescription.value.trim();
    let questionExplanation = questionInputExplanation.value.trim();
    let questionType = document.getElementById("question_type_checkbox_id").checked ? 1 : 0;

    let answers = [];
    let answersDiv = document.querySelector(".all_answers_for_question_div");
    for (let i = 0; i < answersDiv.children.length; i++) {
        let answerText = answersDiv.children[i]
            .querySelector(".answer_input")
            .value.trim();

        let isCorrect =
            answersDiv.children[i].querySelector(".answer_checkbox").checked;
        isCorrect = isCorrect ? 1 : 0;

        answers.push({
            description: answerText,
            correct: isCorrect,
            explanation: "",
        });
    }

    let savedQuestion = {
        id: questionId,
        title: questionTitle,
        answers: answers,
        description: questionDescription,
        explanation: questionExplanation,
        type: questionType,
    };

    if(!validateSubmission(savedQuestion.answers)) {
        return;
    }

    saveQuestion(savedQuestion, lecturerId, quizId).then((questions) => {

        const contextsavedquestions = {
            questions: questions,
        };

        // Remove the saved questions list.
        let questionsList = document.querySelector("#saved_questions_list");
        questionsList.remove();

        // Re-render saved questions list.
        Templates.renderForPromise(
            "mod_livequiz/saved_questions_list",
            contextsavedquestions
        )
            .then(({html, js}) => {
                Templates.appendNodeContents("#saved-questions-container", html, js);
                addEditQuestionListeners(quizId, lecturerId);
                addDeleteQuestionListeners(quizId, lecturerId);
            })
            .catch((error) => displayException(error));
    });
    // Remove edit question pop-up
    let modalDiv = document.querySelector(".Modal_div");
    modalDiv.remove();
}

/**
 *
 * @param questionData
 */
function restoreQuestionDataInPopup(questionData){
    document.getElementById("question_title_id").value = questionData.questiontitle;
    document.getElementById("question_description_id").value = questionData.questiondescription;
    document.getElementById("question_explanation_id").value = questionData.questionexplanation;
    document.getElementById("question_type_checkbox_id").checked = questionData.questiontype === 'radio';
    let answers = questionData.answers;
    for(let i=0; i < answers.length; i++){
        restoreAnswerDataInPopup(answers[i]);
    }
}

/**
 *
 * @param answer
 */
function restoreAnswerDataInPopup(answer) {
    let answerContainer = createAnswerContainer(answer.answerid);
    answerContainer.querySelector(".answer_input").value = answer.answerdescription;
    answerContainer.querySelector(".answer_checkbox").checked = answer.answercorrect;
    let parentElement = document.querySelector(".all_answers_for_question_div");
    parentElement.appendChild(answerContainer);
}


