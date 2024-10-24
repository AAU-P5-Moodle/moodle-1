<?php

namespace mod_livequiz\questions_answers_relation;

use dml_exception;
use dml_transaction_exception;
use mod_livequiz\answers\answers;

/**
 * 'Static' class, do not instantiate.
 * Handles the logic related to the questions_answers relation.
 */
class questions_answers_relation
{
    /**
     * Append an answer to a question, given their ids
     *
     * @param $question_id int
     * @param $answer_id int
     * @return void
     * @throws dml_transaction_exception
     */
    public static function append_answer_to_question(int $questionid, int $answerid): void
    {
        global $DB;
        try {
            $transaction = $DB->start_delegated_transaction();

            $DB->insert_record('livequiz_questions_answers', ['question_id' => $questionid, 'answer_id' => $answerid]);

            $transaction->allow_commit();
        } catch (dml_exception $e) {
            $transaction->rollback($e);
            throw $e;
        }

    }

    /**
     * Get all answers from a question, given its id
     *
     * @param $questionid int
     * @return array
     * @throws dml_exception
     */
    public static function get_answers_from_question(int $questionid): array
    {
        global $DB;

        $answerrecords = $DB->get_records('livequiz_questions_answers', ['question_id'=>$questionid], '', 'question_id');
        $answerids = array_column($answerrecords, 'question_id');
        $answers = [];

        foreach ($answerids as $answerid){
            $answers[] = answers::get_answer_from_id($answerid);
        }

        return $answers;
    }

    //TODO discuss deletion
    //    public static function remove_answer_from_question ($) {
    //
    //    }
}
