<?php

namespace mod_livequiz\question;

use mod_livequiz\questions_answers_relation\questions_answers_relation;
use mod_livequiz\quiz_questions_relation\quiz_questions_relation;

class question
{
    public function __construct($correct, $description, $explanation, $quizid)
    {
        global $DB;
        try {
            $transaction = $DB->start_delegated_transaction();

            $this->$correct = $correct;
            $this->$description = $description;
            $this->$explanation = $explanation;


            $question_id = $DB->insert_record('livequiz_questions', $this);

            quiz_questions_relation::append_questions_to_quiz([$this], $quizid);

            $transaction->allow_commit();
        } catch (dml_exception $e) {
            $transaction->rollback($e);
        }

        return $question_id;
    }

    public static function get_question_from_id($id) {
        global $DB;
        $question = $DB->get_record('livequiz_questions', ['id'=>$id]);
        $answers = questions_answers_relation::get_answers_from_question($question->id);
        $question->answers = $answers;
        return $question;
    }

    public static function update_question($questiondata) {
        global $DB;
        return $DB->update_record('livequiz_questions', $questiondata);
    }

    public static function delete_question($questiondata) {
        global $DB;
    }
}