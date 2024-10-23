<?php

namespace mod_livequiz\livequiz;

use DateTime;
use dml_exception;
use mod_livequiz\question\question;
use mod_livequiz\quiz_questions_relation\quiz_questions_relation;


class livequiz
{
    /**
     * @throws dml_exception
     */


    public function __construct($name, $course_id, $intro, $introformat, $timecreated, $timeupdated)
    {
        global $DB;
        try {
            $transaction = $DB->start_delegated_transaction();

            $this->$name = $name;
            $this->$course_id = $course_id;
            $this->$intro = $intro;
            $this->$introformat = $introformat;
            $this->$timecreated = $timecreated;
            $this->$timeupdated = $timeupdated;

            $quiz_id = $DB->insert_record('livequiz', $this);
            //$question_ids = $DB->insert_records('livequiz_questions', $questions);
            //$DB->insert_records('livequiz_quiz_questions', ['quiz_id' => $quiz_id, 'question_id' => $question_ids]);

            //foreach ($questions as $question) {
            //    $question_id = $DB->insert_record('livequiz_questions', $question);
            //    $DB->insert_record('livequiz_quiz_questions', ['quiz_id' => $quiz_id, 'question_id' => $question_id]);
            //}

            $transaction->allow_commit();
        } catch (dml_exception $e) {
            $transaction->rollback($e);
        }

        return $quiz_id;
    }

    /**
     * @throws dml_exception
     */
    public static function get_livequiz_instance($id)
    {
        global $DB;
        $new_quiz = new \stdClass();
        $quiz_instance = $DB->get_record('livequiz', ['id'=>$id]);
        $new_quiz->id = $quiz_instance->id;
        $new_quiz->name = $quiz_instance->name;
        $new_quiz->course = $quiz_instance->course;
        $new_quiz->intro = $quiz_instance->intro;
        $new_quiz->introformat = $quiz_instance->introformat;
        $new_quiz->timecreated = $quiz_instance->timecreated;
        $new_quiz->timemodified = $quiz_instance->timemodified;

        $questions = quiz_questions_relation::get_questions_from_quiz_id($new_quiz->$id);

        $new_quiz->questions = $questions;

        return $new_quiz;
    }
}