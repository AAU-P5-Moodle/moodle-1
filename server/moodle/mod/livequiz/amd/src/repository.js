

import {call as fetchMany} from 'core/ajax';

// Function to insert a participation.
export const insert_participation = (quizid, studentid) => fetchMany([
    {
        methodname: 'mod_livequiz_insert_participation',
        args: {
            quizid,
            studentid
        },
    }
])[0];

// Function to insert an answer choice.
export const insert_answer_choice = (studentid, answerid, participationid) => fetchMany([
    {
        methodname: 'mod_livequiz_insert_answer_choice',
        args: {
            studentid,
            answerid,
            participationid
        },
    }
])[0];

// A function to update session.
export const update_session = (questionid, answers) => fetchMany([
    {
        methodname: 'mod_livequiz_update_session',
        args: {
            questionid,
            answers
        },
    }
])[0];

