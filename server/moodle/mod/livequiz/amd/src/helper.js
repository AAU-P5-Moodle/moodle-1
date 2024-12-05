import Templates from "core/templates";

let IDs = 0;

/**
 * Adds an event listener to the "Add Answer" button.
 * When the button is clicked, it appends a new answer input field.
 *
 * @returns {void}
 */
export const addAnswerButtonEventListener = () => {
  // Adding event listener to add answer button.
    let answerButton = document.querySelector(".add_new_answer_to_question");
    answerButton.addEventListener("click", () => {
        appendAnswerInput();
    });
};

/**
 * This function creates a new answer container with an incremented ID and appends it to the
 * element with the class "all_answers_for_question_div".
 *
 * @returns {void}
 */
export function appendAnswerInput() {
    let answerContainer = createAnswerContainer(IDs + 1);
    let parentElement = document.querySelector(".all_answers_for_question_div");
    parentElement.appendChild(answerContainer);
    IDs++;
}

/**
 * Creates a new answer container element.
 *
 * @param {int} id - The unique identifier for the answer container.
 * @returns {HTMLDivElement} The created answer container element.
 */
export function createAnswerContainer(id) {
    let answerContainer = document.createElement("div");
    answerContainer.className = "container_for_new_answer";

    let answerInput = document.createElement("input");
    answerInput.className = "answer_input";
    answerInput.placeholder = "Enter answer";
    answerInput.id = "answer_input_" + id;
    answerInput.setAttribute("required", true);

    let answerCheckbox = document.createElement("input");
    answerCheckbox.setAttribute("type", "checkbox");
    answerCheckbox.className = "answer_checkbox";
    answerCheckbox.id = "answer_checkbox_" + id;

    let deleteAnswerButton = createElement(
        "button",
        "delete_answer_button",
        "X"
    );
    deleteAnswerButton.id = "delete_answer_button_" + id;

    answerContainer.appendChild(answerCheckbox);
    answerContainer.appendChild(answerInput);
    answerContainer.appendChild(deleteAnswerButton);

    deleteAnswerButton.addEventListener("click", () => {
        answerContainer.remove();
    });
    return answerContainer;
}

/**
 * Creates a new HTML element with the specified type, class, and content.
 *
 * @param {string} type - The type of the HTML element to create (e.g., 'div', 'span').
 * @param {string} className - The class name to assign to the created element.
 * @param {string} content - The text content to set for the created element.
 * @returns {HTMLElement} The newly created HTML element.
 */
function createElement(type, className, content) {
    let elementName = document.createElement(type);
    elementName.className = className;
    elementName.textContent = content;
    return elementName;
}

/**
 * Rerenders the saved questions list.
 *
 * This function removes the existing saved questions list from the DOM,
 * Renders the "mod_livequiz/saved_questions_list" template with the provided questions
 * After re-rendering, it calls the provided callback function, if any.
 *
 * @param {Array} questions - An array of question objects to be rendered.
 * @param {Function} [callback] - An optional callback function to be executed after the list is re-rendered.
 * @returns {void}
 */
export function rerenderSavedQuestionsList(questions, callback) {
    // The template needs to know the questions to render.
    const contextSavedQuestions = {
        questions: questions,
    };

    // Remove the saved questions list.
    let questionsList = document.querySelector("#saved_questions_list");
    questionsList.remove();

    // Re-render saved questions list.
    Templates.renderForPromise(
        "mod_livequiz/saved_questions_list",
        contextSavedQuestions,
        "boost"
    )
      .then(({html, js}) => {
            Templates.appendNodeContents("#saved_questions_container", html, js);

            // Call the functions in callback, this allows for custom functions to be called after the rerendering.
            if (typeof callback === "function") {
                callback();
            }
        })
        .catch((error) => window.console.log(error));
}

/**
 * Renders the "mod_livequiz/take_quiz_button" template based on whether there are questions in the quiz.
 *
 * @param {string} url - The URL for the "Take Quiz" button to redirect to.
 * @param {boolean} hasQuestions - Indicates if the quiz has questions.
 * @param {function} [callback] - Optional callback function to execute after re-rendering.
 * @returns {void}
 */
export function rerenderTakeQuizButton(url, hasQuestions, callback) {
  // The template needs to know if there are questions in the quiz.
  // If there are questions -> Create a button to redirect to the quiz.
  // If there are no questions -> Display a paragraph that says there are no questions.

    const contextTakeQuiz = {
        url: url,
        hasquestions: hasQuestions,
    };

    if (hasQuestions) {
        // Remove no question paragraph if there are questions.
        let noQuestionParagraph = document.querySelector(".no_question_text");
        if (noQuestionParagraph) {
            noQuestionParagraph.remove(); // We have just added a question so remove the no question text.
        } else {
            let takeQuizButton = document.querySelector("#take_quiz_button");
            takeQuizButton.remove();
        }
    } else {
        // Remove take quiz link if there are no questions.
        let takeQuizButton = document.querySelector("#take_quiz_button");
        takeQuizButton.remove();
    }

    Templates.renderForPromise("mod_livequiz/take_quiz_button", contextTakeQuiz, "boost")
        // It returns a promise that needs to be resolved.
        .then(({html, js}) => {
            // Here we have compiled template.
            Templates.appendNodeContents("#page_mod_livequiz_quizcreator", html, js);
            if (typeof callback === "function") {
                callback();
            }
        })
        .catch((error) => window.console.log(error));
}

/**
 * Sets up the event listener for the cancel button.
 *
 * @param {string} context - The context in which the cancel button is being used.
 * @returns {void}
 */
export function addCancelEditButtonListener(context) {
    let discardQuestionButton = document.querySelector(
        ".cancel_question_button"
    );
    let modalDiv = document.querySelector(".backdrop");
    let stringForConfirm = "";

    // Set the string for the confirmation box based on the context.
    switch (context) {
        case "create":
            stringForConfirm = "Are you sure you want to cancel creating the question?";
            break;
        case "edit":
            stringForConfirm = "Are you sure you want to cancel editing the question?";
            break;
        case "import":
            stringForConfirm = "Are you sure you want to cancel importing the question?";
            break;
        default:
            stringForConfirm = "Are you sure you want to cancel the changes made?";
    }
    discardQuestionButton.addEventListener("click", () => {
        if (confirm(stringForConfirm)) {
            modalDiv.remove();
        }
    });
}


/**
 * This validates that all inputs to create/edit question, if not all inputs are satisfied, it will return false.
 *
 * @param {Object} answers The answers of the question.
 * @returns {boolean} True if input fields are satisfied, false otherwise.
 */
export function validateSubmission(answers) {
    let isValid = true; // Is the question valid.
    let answersValid = true; // Are all the answers valid.
    let questionTitle = document.getElementById("question_title_id").value.trim();
    let questionTitleTextarea = document.getElementById("question_title_id");
    let questionTitleAlert = document.getElementById("title_textarea_alert");
    let questionDescription = document.getElementById("question_description_id").value.trim();
    let questionDescriptionTextarea = document.getElementById("question_description_id");
    let questionDescriptionAlert = document.getElementById("question_textarea_alert");
    let atLeastOneCorrectAnswerAlert = document.getElementById("question_alert_one_correct");
    let answerDescriptionAlert = document.getElementById("question_alert_description");
    let atLeastTwoAnswersAlert = document.getElementById("question_alert_two_answers");
    let maxOneCorrectAnswerAlert = document.getElementById("question_alert_max_one_correct");
    let questionType = document.getElementById("question_type_checkbox_id").checked;
    let answersBox = document.getElementById("all_answers");
    let isValidText = document.getElementById("validText");

  // Function to set the border style of an element.
    const setBorderStyle = (element, isValid) => {
        element.style.border = isValid ? "1px solid #ccc" : "1px solid red";
    };

    // Checks if the question title is empty.
    if (!questionTitle) {
        setBorderStyle(questionTitleTextarea, !!questionTitle);
        questionTitleAlert.style.display = "block";
        isValid = false;
    } else {
        questionTitleAlert.style.display = "none";
        setBorderStyle(questionTitleTextarea, true);
    }

    // Checks if the question description is empty.
    if (!questionDescription) {
        setBorderStyle(questionDescriptionTextarea, !!questionDescription);
        questionDescriptionAlert.style.display = "block";
        isValid = false;
    } else {
        questionDescriptionAlert.style.display = "none";
        setBorderStyle(questionDescriptionTextarea, true);
    }

    // Checks if there are at least two answers.
    if (answers.length < 2) {
        isValid = false;
        answersValid = false;
        atLeastTwoAnswersAlert.style.display = "block";
    } else {
        atLeastTwoAnswersAlert.style.display = "none";
    }

  // Checks if at least one answer is correct.
    if (!answers.some(answer => answer.correct === 1)) {
        isValid = false;
        answersValid = false;
        atLeastOneCorrectAnswerAlert.style.display = "block";
    } else {
        atLeastOneCorrectAnswerAlert.style.display = "none";
    }

    // Checks if all answers have a description.
    if (answers.some(answer => !answer.description.trim())) {
        isValid = false;
        answersValid = false;
        answerDescriptionAlert.style.display = "block";
    } else {
        answerDescriptionAlert.style.display = "none";
    }

  // Checks if multiple correct answers have been set, when not allowed to.
    if (questionType) {
        let checkedAnswers = 0;
        answers.forEach(answer => {
            checkedAnswers += answer.correct;
        });
        if (checkedAnswers > 1) {
            isValid = false;
            answersValid = false;
            maxOneCorrectAnswerAlert.style.display = "block";
        } else {
            maxOneCorrectAnswerAlert.style.display = "none";
        }
    } else {
          maxOneCorrectAnswerAlert.style.display = "none";
    }

    if (!answersValid) { // If not all answers are valid show the box with warnings.
        answersBox.style.display = "block";
    } else {
        answersBox.style.display = "none";
    }

    if (!isValid) { // If the question is not valid show warning.
        isValidText.style.display = "block";
        return false;
    }
    return true;
}

/**
 * Gets question data inputted in the UI. Used when creating or editing a question.
 *
 * @returns {{description: *, title: *, explanation: *, type: (number)}}
 */
export function getQuestionData() {
    let questionTitle = document.getElementById("question_title_id").value.trim();
    let questionDescription = document.getElementById("question_description_id").value.trim();
    let questionExplanation = document.getElementById("question_explanation_id").value.trim();
    let questionType = document.getElementById("question_type_checkbox_id").checked ? 1 : 0;

    return {
        title: questionTitle,
        description: questionDescription,
        explanation: questionExplanation,
        type: questionType
    };
}

/**
 * Gets the data for each answer inputted in the UI. Used when creating or editing a question.
 *
 * @returns {array}
 */
export function prepareAnswers() {
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
    return answers;
}
