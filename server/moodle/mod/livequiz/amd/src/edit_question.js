import Templates from "core/templates";
import {saveQuestion, getQuestion} from "./repository";
import {
    addAnswerButtonEventListener,
    createAnswerContainer,
    addCancelEditButtonListener,
    validateSubmission,
    getQuestionData, prepareAnswers,
} from "./helper";
import {addDeleteQuestionListeners} from "./delete_question";

/**
 * Adds event listeners for when the questions in the list of saved questions are clicked.
 *
 * @param {int} quizId
 * @param {int} lecturerId
 * @returns {Promise<void>}
 */
export const init = async(quizId, lecturerId) => {
    addEditQuestionListeners(quizId, lecturerId);
};

/**
 * Helper function for adding click-event listeners on the saved questions.
 *
 * @param {int} quizId
 * @param {int} lecturerId
 * @returns {void}
 */
export function addEditQuestionListeners(quizId, lecturerId) {
    let questionList = document.getElementById("saved_questions_list");
    questionList.addEventListener("click", (event) => {
        let target = event.target;
        if (target.classList.contains("edit-question-btn") || target.classList.contains("question_list_text")) {
            let questionId = parseInt(target.dataset.id, 10);
            renderEditQuestionMenuPopup(quizId, lecturerId, questionId);
        }
    });
}

/**
 * Render the pop-up for editing a given question.
 *
 * @param {int} quizId
 * @param {int} lecturerId
 * @param {int} questionId
 * @returns {void}
 */
function renderEditQuestionMenuPopup(quizId, lecturerId, questionId) {

if(!document.querySelector('.modal_div')){
    // This will call the function to load and render our template.
    Templates.renderForPromise("mod_livequiz/question_menu_popup", {}, "boost")

        // It returns a promise that needs to be resolved.
        .then(({html, js}) => {
            // Here we have the compiled template.
            Templates.appendNodeContents(".main_container", html, js);
            getQuestion(quizId, questionId)
                .then((question)=> {
                    restoreQuestionDataInPopup(question);
                })
                .catch((error) => window.console.log(error));
            addAnswerButtonEventListener();
            addSaveQuestionButtonListener(quizId, lecturerId, questionId);
            addCancelEditButtonListener("edit");
        })
      .catch((error) => window.console.log(error)); // Deal with this exception (Using core/notify exception function is recommended).
  }
}

/**
 * Adds an event listener to the save question button.
 *
 * @param {int} quizId
 * @param {int} lecturerId
 * @param {int} questionId
 * @returns {void}
 */
function addSaveQuestionButtonListener(quizId, lecturerId, questionId) {
    let saveQuestionButton = document.querySelector(".save_button");
    saveQuestionButton.addEventListener("click", () => {
        handleSaveQuestion(quizId, lecturerId, questionId);
    });
}

/**
 * Event handler for when a question is saved.
 *
 * @param {int} quizId
 * @param {int} lecturerId
 * @param {int} questionId
 * @returns {void}
 */
function handleSaveQuestion(quizId, lecturerId, questionId) {
    let questionData = getQuestionData();
    let savedQuestion = {
        id: questionId,
        title: questionData.title,
        answers: prepareAnswers(),
        description: questionData.description,
        explanation: questionData.explanation,
        type: questionData.type,
    };

    if (!validateSubmission(savedQuestion.answers)) {
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
            contextsavedquestions,
            "boost"
        )
            .then(({html, js}) => {
                Templates.appendNodeContents("#saved_questions_container", html, js);
                addEditQuestionListeners(quizId, lecturerId);
                addDeleteQuestionListeners(quizId, lecturerId);
            })
            .catch((error) => displayException(error));
    }).catch(() => alert("Cannot edit a question, since it already has participations"));
    //Remove edit question pop-up
    let modalDiv = document.querySelector(".backdrop");
    modalDiv.remove();
}

/**
 * The data for the question passed as argument is rendered in the edit-question pop-up.
 *
 * @param {Object} questionData
 * @returns {void}
 */
function restoreQuestionDataInPopup(questionData) {
    document.getElementById("question_title_id").value = questionData.questiontitle;
    document.getElementById("question_description_id").value = questionData.questiondescription;
    document.getElementById("question_explanation_id").value = questionData.questionexplanation;
    document.getElementById("question_type_checkbox_id").checked = questionData.questiontype === 'radio';
    let answers = questionData.answers;
    for (let i = 0; i < answers.length; i++) {
        restoreAnswerDataInPopup(answers[i]);
    }
}

/**
 * The data for the answer passed as argument is rendered in the edit-question pop-up.
 *
 * @param {Object} answer
 * @returns {void}
 */
function restoreAnswerDataInPopup(answer) {
    let answerContainer = createAnswerContainer(answer.answerid);
    answerContainer.querySelector(".answer_input").value = answer.answerdescription;
    answerContainer.querySelector(".answer_checkbox").checked = answer.answercorrect;
    let parentElement = document.querySelector(".all_answers_for_question_div");
    parentElement.appendChild(answerContainer);
}
