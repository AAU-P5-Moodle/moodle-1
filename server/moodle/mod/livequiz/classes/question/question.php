<?php

namespace mod_livequiz\question;

use dml_exception;
use dml_transaction_exception;
use mod_livequiz\answers\answers;
use mod_livequiz\questions_answers_relation\questions_answers_relation;
use mod_livequiz\quiz_questions_relation\quiz_questions_relation;
use stdClass;

class question
{
    private $title;
    private $description;
    private $timelimit;
    private $explanation;
    private $answers = [];

    /**
     * Constructor for the question class.
     *
     * @param $title
     * @param $description
     * @param $timelimit
     * @param $explanation
     */
    public function __construct($title, $description, $timelimit, $explanation) //,$answers, $quizid
    {
        $this->title = $title;
        $this->description = $description;
        $this->timelimit = $timelimit;
        $this->explanation = $explanation;

        return $this;
    }

    /**
     * This function is used to submit a question to the database.
     *
     * @param $question
     * @return int
     * @throws dml_exception
     * @throws dml_transaction_exception
     */
    public static function submit_question($question) {
        global $DB;
        try {
            $transaction = $DB->start_delegated_transaction();
            $questiondata = [
                    'title' => $question->title,
                    'description' => $question->description,
                    'timelimit' => $question->timelimit,
                    'explanation' => $question->explanation,
                ];

            $questionid = $DB->insert_record('livequiz_questions', $questiondata);
            $transaction->allow_commit();
            return $questionid;
        } catch (dml_exception $e) {
            $transaction->rollback($e);
            throw $e;
        }
    }

    /**
     * Gets a question instance, with all relevant attributes
     *
     * @param $id
     * @return stdClass
     * @throws dml_exception
     */
    public static function get_question_from_id($id) {
        global $DB;
        $question = $DB->get_record('livequiz_questions', ['id'=>$id]);
        $answers = questions_answers_relation::get_answers_from_question($question->id);
        $question->answers = $answers;
        return $question;
    }

    /**
     * When a question is being made in the front-end,
     * this function should be called to create an answer
     * associated with the specific question.
     *
     * @param $correct
     * @param $description
     * @param $explanation
     * @return void
     * @throws dml_exception
     * @throws dml_transaction_exception
     */
    public function new_answer_option($correct, $description, $explanation) {
        $this->answers[] = new answers($correct, $description, $explanation);
    }

    /**
     * TODO: Implement this method
     * Update a question
     *
     * @param $questiondata
     * @return bool
     * @throws dml_exception
     */
    public static function update_question($questiondata) {
        global $DB;
        return $DB->update_record('livequiz_questions', $questiondata);
    }

    /**
     * TODO: Implement this method
     * Delete a question
     *
     * @param $questiondata
     * @throws dml_exception
     */
    public static function delete_question($questiondata) {
        global $DB;
    }

    // Getters for the private fields of an instance Question object.
    public function get_title() {
        return $this->title;
    }
    public function get_description() {
        return $this->description;
    }
    public function get_timelimit() {
        return $this->timelimit;
    }
    public function get_explanation() {
        return $this->explanation;
    }
    public function get_answers() {
        return $this->answers;
    }
}
