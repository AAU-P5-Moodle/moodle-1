<?php

namespace mod_livequiz\questions_answers_relation;

use mod_livequiz\answers\answers;

class questions_answers_relation
{
    public static function append_answer_to_question($question_id, $answer_id) {

        global $DB;

        try {
            $transaction = $DB->start_delegated_transaction();

            $DB->insert_record('livequiz_questions_answers', ['question_id' => $question_id, 'answer_id' => $answer_id]);

            $transaction->allow_commit();
        } catch (dml_exception $e) {
            $transaction->rollback($e);
        }

    }

    public static function get_answers_from_question($questionid){
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