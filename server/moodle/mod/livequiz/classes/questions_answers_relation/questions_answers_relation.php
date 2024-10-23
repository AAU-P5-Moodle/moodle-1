<?php

namespace mod_livequiz\questions_answers_relation;

class questions_answers_relation
{
    public static function append_answer_to_question($question_id, $answer_id) {

        global $DB;

        try {
            $transaction = $DB-start_delegated_transaction();

            $DB->insert_record('livequiz_questions_answers', ['question_id' => $question_id, 'answer_id' => $answer_id]);

            $transaction->allow_commit();
        } catch (dml_exception $e) {
            $transaction->rollback($e);
        }

    }

    //TODO discuss deletion
//    public static function remove_answer_from_question ($) {
//
//    }
}