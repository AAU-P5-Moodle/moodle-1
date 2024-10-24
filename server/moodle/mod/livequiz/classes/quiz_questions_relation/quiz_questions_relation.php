<?php

namespace mod_livequiz\quiz_questions_relation;

use dml_exception;
use dml_transaction_exception;
use mod_livequiz\question\question;

class quiz_questions_relation
{
    /**
     * Append a list of questions to a quiz, given its id
     *
     * @param $questions array of question objects
     * @param $quizid int
     * @return void
     * @throws dml_exception
     */
    public static function append_questions_to_quiz($questions, $quizid)
    {
        global $DB;
        try {
            $transaction = $DB->start_delegated_transaction();

            foreach ($questions as $question) {
                $questionid = $DB->insert_record('livequiz_questions', $question);
                $DB->insert_record('livequiz_quiz_questions', ['quiz_id' => $quizid, 'question_id' => $questionid]);
            }

            $transaction->allow_commit();
        } catch (dml_exception $e) {
            $transaction->rollback($e);
        }
    }

    /**
     *  Append a question object to a quiz, given its id
     *
     * @param $question
     * @param $quizid
     * @return void
     * @throws dml_exception
     * @throws dml_transaction_exception
     */
    public static function append_question_to_quiz($question, $quizid)
    {
        global $DB;
        try {
            $transaction = $DB->start_delegated_transaction();

            $questionid = $DB->insert_record('livequiz_questions', $question);
            $DB->insert_record('livequiz_quiz_questions', ['quiz_id' => $quizid, 'question_id' => $questionid]);

            $transaction->allow_commit();
        } catch (dml_exception $e) {
            $transaction->rollback($e);
        }
    }

    /**
     * Get all questions from a quiz, given its id
     *
     * @param $quizid int
     * @return array of question objects
     * @throws dml_exception
     */
    public static function get_questions_from_quiz_id($quizid): array
    {
        global $DB;

        $question_records = $DB->get_records('livequiz_quiz_questions', ['quiz_id'=>$quizid], '', 'question_id');
        $question_ids = array_column($question_records, 'question_id');
        $questions = [];

        foreach ($question_ids as $question_id){
            $questions[] = question::get_question_from_id($question_id);
        }

        return $questions;
    }
}