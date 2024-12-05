import {call as fetchMany} from 'core/ajax';


/**
 * Call the submit_quiz service (see "external" folder). Used when a lecturer or student submits answer choices to a quiz.
 *
 * @param quizid
 * @param studentid
 * @param resultsurl
 */
export const submitQuiz = async(quizid, studentid, resultsurl) => fetchMany([
    {
        methodname: 'mod_livequiz_submit_quiz',
        args: {
            quizid,
            studentid,
            resultsurl
        },
    }
])[0];

/**
 * Calls the update_session service (see "external" folder). Used when a lecturer or student attempts a quiz.
 *
 * @param quizid
 * @param questionid
 * @param answers
 */
export const updateSession = (quizid, questionid, answers) => fetchMany([
    {
        methodname: 'mod_livequiz_update_session',
        args: {
            quizid,
            questionid,
            answers
        },
    }
])[0];

/**
 * Calls the save_question service (see "external" folder). Used when a lecturer adds or edits a quiz.
 *
 * @param question
 * @param lecturerid
 * @param quizid
 */
export const saveQuestion = (question, lecturerid, quizid) => fetchMany([
    {
        methodname: 'mod_livequiz_save_question',
        args: {
            question,
            lecturerid,
            quizid
        },
    }
])[0];

/**
 * Calls the delete_question service (see "external" folder). Used when a lecturer deletes a question from a quiz.
 *
 * @param questionid
 * @param lecturerid
 * @param quizid
 */
export const deleteQuestion = (questionid, lecturerid, quizid) => fetchMany([
    {
        methodname: 'mod_livequiz_delete_question',
        args: {
            questionid,
            lecturerid,
            quizid
        },
    }
])[0];


/**
 * Calls the get_question service (see "external" folder). Used when a lecturer opens a questions for editing.
 *
 * @param quizid
 * @param questionid
 */
export const getQuestion = (quizid, questionid) => fetchMany([
    {
        methodname: 'mod_livequiz_get_question',
        args: {
            quizid,
            questionid
        },
    }
])[0];

/**
 * Calls the reuse_question service (see "external" folder). Used when a lecturer imports questions from one quiz to another.
 *
 * @param quizid
 * @param questionids
 * @param lecturerid
 */
export const externalReuseQuestions = (quizid, questionids, lecturerid) => fetchMany([
    {
        methodname: 'mod_livequiz_reuse_question',
        args: {
            quizid,
            questionids,
            lecturerid
        },
    }
])[0];

/**
 * Calls the get_lecturer_quiz service (see "external" folder).
 *
 * @param lecturerid
 */
export const getLecturerQuiz = (lecturerid) => fetchMany([
    {
        methodname: 'mod_livequiz_get_lecturer_quiz',
        args: {
            lecturerid
        },
    }
])[0];