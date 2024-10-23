<?php

namespace mod_livequiz\livequiz;

use DateTime;
use dml_exception;
use mod_livequiz\question\question;



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

    public static function append_questions_to_quiz($questions, $quiz_id): void
    {
        global $DB;
        try {
            $transaction = $DB->start_delegated_transaction();

            foreach ($questions as $question) {
                $question_id = $DB->insert_record('livequiz_questions', $question);
                $DB->insert_record('livequiz_quiz_questions', ['quiz_id' => $quiz_id, 'question_id' => $question_id]);
            }

            $transaction->allow_commit();
        } catch (dml_exception $e) {
            $transaction->rollback($e);
        }
    }

    /**
     * @throws dml_exception
     */
    public static function get_livequiz_instance($id)
    {
        global $DB;
        $new_quiz = new \stdClass();
        $quiz_instace = $DB->get_record('livequiz', [$id]);
        $new_quiz->id = $quiz_instace->id;
        $new_quiz->name = $quiz_instace->name;
        $new_quiz->course = $quiz_instace->course;
        $new_quiz->intro = $quiz_instace->intro;
        $new_quiz->introformat = $quiz_instace->introformat;
        $new_quiz->timecreated = $quiz_instace->timecreated;
        $new_quiz->timemodified = $quiz_instace->timemodified;

//        $question_ids = $DB->get_records('livequiz_quiz_questions', ['quiz_id'=>$new_quiz->id], '', 'question_id');
//        $questions = [];
//        foreach ($question_ids as $question_id){
//            $questions[] = $DB->get_record('livequiz_questions', $question_id);
//        }
//
//        $new_quiz->questions = $questions;




//        $new_quiz = $DB->get_record_sql('
//            SELECT lq.*
//            FROM {livequiz} lq
//            JOIN {livequiz_quiz_questions} lqi ON lq.id = lqi.quiz_id
//            JOIN {livequiz_questions} lqz ON lqi.question_id = lqz.id
//            WHERE lq.id = ?', array($id));
        return $quiz_instace;
    }
}