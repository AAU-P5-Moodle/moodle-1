<?php

namespace mod_livequiz\answers;

use mod_livequiz\questions_answers_relation\questions_answers_relation;
use mod_livequiz\quiz_questions_relation\quiz_questions_relation;

class answers
{
    /**
     * @throws dml_exception
     */
    public function __construct($correct, $description, $explanation, $question_id)
    {
        global $DB;
        try{
            $transaction = $DB->start_delegated_transaction();

            $this->$correct = $correct;
            $this->$description = $description;
            $this->$explanation = $explanation;

            //Inserts the Answer
            $answer_id = $DB->insert_record('livequiz_answers', $this);

            //Appends answer to question
            questions_answers_relation::append_answer_to_question($question_id, $answer_id);
        } catch (dml_exception $e) {
            $transaction->rollback($e);
        }
        return $answer_id;
    }

    public static function update_answer($answer)
    {
        global $DB;
        return $DB->update_record('livequiz_answers', ['id' => $answer->id]);
    }

    // TODO Discuss deletion
//    public static function delete_answer($answer)
//    {
//        global $DB;
//        $id = $answer->id;
//        $DB->delete_records('livequiz_answers', ['id'=>$id]);
//    }
//}