import {call as fetchMany} from 'core/ajax';

// Function to insert a participation.
export const submit_quiz = async(quizid, studentid, resultsurl) => fetchMany([
    {
        methodname: 'mod_livequiz_submit_quiz',
        args: {
            quizid,
            studentid,
            resultsurl
        },
    }
])[0];

// A function to update session.
export const update_session = (quizid, questionid, answers) => fetchMany([
    {
        methodname: 'mod_livequiz_update_session',
        args: {
            quizid,
            questionid,
            answers
        },
    }
])[0];

// Function to save a question.
export const save_question = (question, lecturerid, quizid) => fetchMany([
    {
        methodname: 'mod_livequiz_save_question',
        args: {
            question,
            lecturerid,
            quizid
        },
    }
])[0];

// Function to delete a question.
export const delete_question = (questionid, lecturerid, quizid) => fetchMany([
    {
        methodname: 'mod_livequiz_delete_question',
        args: {
            questionid,
            lecturerid,
            quizid
        },
    }
])[0];


// Function to retrieve a question.
export const get_question = (quizid, questionid) => fetchMany([
    {
        methodname: 'mod_livequiz_get_question',
        args: {
            quizid,
            questionid
        },
    }
])[0];

export const external_reuse_questions = (quizid, questionids) => fetchMany([
    {
        methodname: 'mod_livequiz_reuse_question',
        args: {
            quizid,
            questionids
        },
    }
])[0];