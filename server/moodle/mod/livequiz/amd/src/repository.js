import {call as fetchMany} from 'core/ajax';

// Function to insert a participation.
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

// A function to update session.
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

// Function to save a question.
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

// Function to delete a question.
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


// Function to retrieve a question.
export const getQuestion = (quizid, questionid) => fetchMany([
    {
        methodname: 'mod_livequiz_get_question',
        args: {
            quizid,
            questionid
        },
    }
])[0];

// Function to reuse questions.
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

// Function to get lecturer questions.
export const getLecturerQuiz = (lecturerid) => fetchMany([
    {
        methodname: 'mod_livequiz_get_lecturer_quiz',
        args: {
            lecturerid
        },
    }
])[0];