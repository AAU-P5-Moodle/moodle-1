<?php

namespace mod_livequiz\question;

class question
{
    public function __construct($correct, $description, $explanation, $question_id)
    {
        global $DB;
        try {
            $transaction = $DB->start_delegated_transaction();

            $this->$correct = $correct;
            $this->$description = $description;
            $this->$explanation = $explanation;


            $question_id = $DB->insert_record('livequiz_questions', $this);

            $transaction->allow_commit();
        } catch (dml_exception $e) {
            $transaction->rollback($e);
        }

        return $question_id;
    }

    public static function update_question($questiondata) {
        global $DB;
        return $DB->update_record('livequiz_questions', $questiondata);
    }

    public static function delete_question($questiondata) {
        global $DB;

    }

}