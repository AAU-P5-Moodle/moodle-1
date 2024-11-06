

import {call as fetchMany} from 'core/ajax';

//simple test function to check if ajax is working
export const test_ajax = (quizid) => fetchMany([
    {
        methodname: 'mod_livequiz_append_participation',
        args: {
            quizid
        },
    }
])[0];

