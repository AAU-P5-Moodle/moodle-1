<?php

namespace mod_livequiz\quiz_questions_relation;

class quiz_questions_relation
{
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

    public static function get_questions_from_quiz_id($quizid)
    {
        global $DB;

        $question_records = $DB->get_records('livequiz_quiz_questions', ['quiz_id'=>$quizid], '', 'question_id');
        $question_ids = array_column($question_records, 'question_id');
        $questions = [];

        //TODO move to question class
        foreach ($question_ids as $question_id){
            $questions[] = $DB->get_record('livequiz_questions', ['id'=>$question_id]);
        }

        return $questions;
    }
}