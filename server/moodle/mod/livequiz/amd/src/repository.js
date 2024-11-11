

import {call as fetchMany} from 'core/ajax';

// Test function to append a participation.
export const append_participation = (quizid, studentid) => fetchMany([
    {
        methodname: 'mod_livequiz_append_participation',
        args: {
            quizid,
            studentid
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

