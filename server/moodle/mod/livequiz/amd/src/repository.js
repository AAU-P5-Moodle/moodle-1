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

