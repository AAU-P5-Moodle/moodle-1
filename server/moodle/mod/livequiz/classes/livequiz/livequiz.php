<?php

namespace mod_livequiz\livequiz;

use DateTime;
use dml_exception;
use mod_livequiz\answers\answers;
use mod_livequiz\question\question;
use mod_livequiz\questions_answers_relation\questions_answers_relation;
use mod_livequiz\quiz_questions_relation\quiz_questions_relation;
use stdClass;

/**
 * This class is essentially supposed to be static.
 * Please do not bother instantiating it.
 */
class livequiz
{

    /**
     * This method stores quiz data in the database.
     * Before calling this method, none of the quiz data is safe.
     * Please make sure that the quiz object is properly populated before using.
     * TODO:
     * Handle lecturer id such that the intermediate table can be updated accordingly.
     * @param $livequizid // ID of the quiz to be submitted.
     * @param $questions // An array of question objects.
     * @throws dml_exception
     */
    public static function submit_quiz_to_database ($livequizid, $questions)
    {
        foreach ($questions as $question) {

            $questionid = question::submit_question($question);

            // Inserting into the quiz_questions relation table
            quiz_questions_relation::append_question_to_quiz($questionid, $livequizid);

            foreach ($question->get_answers() as $answer) {

                $answerid = answers::submit_answer($answer);

                // Inserting into the questions_answers relation table
                questions_answers_relation::append_answer_to_question($questionid, $answerid);
            }
        }
    }


    /**
     * Gets a livequiz instance, with all relevant attributes
     *
     * @param $id
     * @param $lecturers
     * @return stdClass
     * @throws dml_exception
     */
    public static function get_livequiz_instance($id)//, $lecturers)
    {
        global $DB;
        $new_quiz = new stdClass();
        $quiz_instance = $DB->get_record('livequiz', ['id'=>$id]);
        $new_quiz->id = $quiz_instance->id;
        $new_quiz->name = $quiz_instance->name;
        $new_quiz->course = $quiz_instance->course;
        $new_quiz->intro = $quiz_instance->intro;
        $new_quiz->introformat = $quiz_instance->introformat;
        $new_quiz->timecreated = $quiz_instance->timecreated;
        $new_quiz->timemodified = $quiz_instance->timemodified;

        $questions = quiz_questions_relation::get_questions_from_quiz_id($new_quiz->id);

        $new_quiz->questions = $questions;

        return $new_quiz;
    }
}