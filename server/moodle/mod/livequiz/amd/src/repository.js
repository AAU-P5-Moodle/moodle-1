

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
export const insert_answer_choices = (studentid, participationid, quizid) => fetchMany([
    {
        methodname: 'mod_livequiz_insert_answer_choice',
        args: {
            studentid,
            participationid,
            quizid
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

