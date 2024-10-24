<?php

namespace mod_livequiz\answers;

use dml_exception;
use dml_transaction_exception;
use mod_livequiz\questions_answers_relation\questions_answers_relation;
use mod_livequiz\quiz_questions_relation\quiz_questions_relation;

class answers
{
    private $correct;
    private $description;
    private $explanation;

    /**
     * Constructor for the answers class. Returns the object
     *
     * @param $correct
     * @param $description
     * @param $explanation
     */
    public function __construct($correct, $description, $explanation)
    {
        $this->correct = $correct;
        $this->description = $description;
        $this->explanation = $explanation;

        return $this;
    }

    /**
     * Given an answer object, this method will insert the answer to the database
     *
     * @param $answer
     * @return bool|int
     * @throws dml_exception
     * @throws dml_transaction_exception
     */
    public static function submit_answer($answer) {
        global $DB;
        try {
            $transaction = $DB->start_delegated_transaction();
            $answerdata = [
                'correct' => $answer->correct,
                'description' => $answer->description,
                'explanation' => $answer->explanation,
            ];

            $answerid = $DB->insert_record('livequiz_answers', $answerdata);
            $transaction->allow_commit();
            return $answerid;
        } catch (dml_exception $e) {
            $transaction->rollback($e);
            throw $e;
        }
    }

    /**
     * TODO: Implement this method
     * Given an edited answer object, this method updates the given object in the database
     *
     * @param $answer
     * @return bool
     * @throws dml_exception
     */
    public static function update_answer($answer)
    {
        global $DB;
        return $DB->update_record('livequiz_answers', ['id' => $answer->id]);
    }

    /**
     * Get an answer, given its id
     *
     * @param $id
     * @return mixed
     * @throws dml_exception
     */
    public static function get_answer_from_id($id): mixed
    {
        global $DB;
        return $DB->get_record('livequiz_answers', ['id'=>$id]);
    }

    // TODO Discuss deletion
    //    public static function delete_answer($answer)
    //    {
    //        global $DB;
    //        $id = $answer->id;
    //        $DB->delete_records('livequiz_answers', ['id'=>$id]);
    //    }
    //}

}

