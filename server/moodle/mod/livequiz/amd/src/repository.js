import {call as fetchMany} from 'core/ajax';

// Function to insert a participation.
export const submit_quiz = (quizid, studentid) => fetchMany([
    {
        methodname: 'mod_livequiz_submit_quiz',
        args: {
            quizid,
            studentid
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

