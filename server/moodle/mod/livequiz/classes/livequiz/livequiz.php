<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace mod_livequiz\livequiz;



use DateTime;
use dml_exception;
use mod_livequiz\answers\answers;
use mod_livequiz\question\question;
use mod_livequiz\questions_answers_relation\questions_answers_relation;
use mod_livequiz\quiz_questions_relation\quiz_questions_relation;
use stdClass;

/**
 * Class livequiz
 *
 * This class represents a livequiz in the LiveQuiz module.
 * It handles creation, retrieval, and updates of livequizzes and their associated questions.
 *
 * @package livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class livequiz {
    /**
     * @var int $id
     */
    private $id;

    /**
     * @var string $name
     */
    private string $name;

    /**
     * @var int $course
     */
    private int $course;

    /**
     * @var string $intro
     */
    private string $intro;

    /**
     * @var int $introformat
     */
    private int $introformat;

    /**
     * @var int $timecreated
     */
    private int $timecreated;

    /**
     * @var int $timemodified
     */
    private int $timemodified;

    /**
     * @var array $questions
     */
    private array $questions;


    /**
     * Constructor for the livequiz class. Returns the object.
     *
     * @param string $name
     * @param int $course
     * @param string $intro
     * @param int $introformat
     * @param int $timecreated
     * @param int $timemodified
     */
    public function __construct(string $name, int $course, string $intro, int $introformat, int $timecreated, int $timemodified) {
        $this->name = $name;
        $this->course = $course;
        $this->intro = $intro;
        $this->introformat = $introformat;
        $this->timecreated = $timecreated;
        $this->timemodified = $timemodified;

        return $this;
    }
    /**
     * This method stores quiz data in the database.
     * Before calling this method, none of the quiz data is safe.
     * Please make sure that the quiz object is properly populated before using.
     * TODO:
     * Handle lecturer id such that the intermediate table can be updated accordingly.
     * @param int $livequizid // ID of the quiz to be submitted.
     * @param array $questions // An array of question objects.
     * @throws dml_exception
     */
    public static function submit_quiz_to_database(int $livequizid, array $questions): void {
        foreach ($questions as $question) {
            $questionid = question::submit_question($question);

            // Inserting into the quiz_questions relation table.
            quiz_questions_relation::append_question_to_quiz($questionid, $livequizid);

            foreach ($question->get_answers() as $answer) {
                $answerid = answers::submit_answer($answer);

                // Inserting into the questions_answers relation table.
                questions_answers_relation::append_answer_to_question($questionid, $answerid);
            }
        }
    }


    /**
     * Gets a livequiz instance, with all relevant attributes.
     *
     * TODO implement associated lecturer.
     *
     * @param int $id
     * @return livequiz
     * @throws dml_exception
     */
    public static function get_livequiz_instance(int $id): livequiz {
        global $DB;
        $quizinstance = $DB->get_record('livequiz', ['id' => $id]);
        $livequiz = new livequiz($quizinstance->name, $quizinstance->course, $quizinstance->intro, $quizinstance->introformat, $quizinstance->timecreated, $quizinstance->timemodified);


        $questions = quiz_questions_relation::get_questions_from_quiz_id($livequiz->id);

        $livequiz->questions = $questions;

        return $livequiz;
    }
}
